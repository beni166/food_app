<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use MyEvent;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Total des commandes
        $totalOrders = Order::count();

        // 2. Revenu total
        $totalRevenue = DB::table('orders_foods')
            ->join('products', 'orders_foods.products_id', '=', 'products.id')
            ->select(DB::raw('COALESCE(SUM(orders_foods.quantity * products.prix), 0) as total'))
            ->value('total');

        // 3. Produits les plus vendus
        $topProducts = products::select('products.name', DB::raw('SUM(orders_foods.quantity) as total_sold'))
            ->join('orders_foods', 'products.id', '=', 'orders_foods.products_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 4. Revenus mensuels (format mois)
        $salesByMonth = DB::table('orders')
            ->join('orders_foods', 'orders.id', '=', 'orders_foods.order_id')
            ->join('products', 'orders_foods.products_id', '=', 'products.id')
            ->selectRaw("DATE_FORMAT(orders.order_date, '%Y-%m') as month, SUM(orders_foods.quantity * products.prix) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // 5. Nombre de commandes par mois
        $ordersByMonthRaw = DB::table('orders')
            ->selectRaw("DATE_FORMAT(order_date, '%Y-%m') as month, COUNT(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // 6. Synchronisation des labels
        $labels = array_unique(array_merge(array_keys($salesByMonth), array_keys($ordersByMonthRaw)));
        sort($labels);

        $salesByMonthFormatted = [];
        $ordersByMonthFormatted = [];

        foreach ($labels as $month) {
            $salesByMonthFormatted[$month] = $salesByMonth[$month] ?? 0;
            $ordersByMonthFormatted[$month] = $ordersByMonthRaw[$month] ?? 0;
        }

        // 7. Panier moyen
        $averageCart = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;

        // 8. Envoi des données à la vue
        return view('Admin.dashbord', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'topProducts' => $topProducts,
            'salesByMonth' => $salesByMonthFormatted,
            'ordersByMonth' => $ordersByMonthFormatted,
            'averageCart' => $averageCart,
            'labels' => $labels,
        ]);
    }

    public function getUser()
    {
        $user = auth()->user();
        return view('Admin.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('Admin.profile.edit', compact('user'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();

        // Infos basiques
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // ✅ Gestion de l’image
        if ($request->hasFile('profile')) {
            // Supprimer l'ancienne image si elle existe
            if ($user->profile && File::exists(public_path($user->profile))) {
                File::delete(public_path($user->profile));
            }

            $file = $request->file('profile');
            $fileName = "profile" . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path("assets/profiles/"), $fileName);
            $user->profile = "assets/profiles/" . $fileName;
        }

        // ✅ Gestion du mot de passe
        if ($request->filled('current_password') && $request->filled('password')) {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = Hash::make($request->password);
            } else {
                return back()->withErrors(['current_password' => 'Mot de passe actuel incorrect.']);
            }
        }

        $user->save();

        return redirect()->route('admin.profile.user')
            ->with('success', 'Profil mis à jour avec succès !');
    }


    public function users()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count(); // ou via relation roles
        $totalClients = User::where('role', 'user')->count();
        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Utilisateurs récents
        $recentUsers = User::latest()->take(5)->get();

        // Inscriptions par mois (dernier année)
        $usersByMonthRaw = User::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("COUNT(*) as total")
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $usersByMonth = [];
        foreach ($usersByMonthRaw as $row) {
            $usersByMonth[$row->month] = $row->total;
        }

        // Assurez que tous les mois sont présents (0 si aucun utilisateur)
        for ($m = 1; $m <= 12; $m++) {
            $monthKey = now()->year . '-' . str_pad($m, 2, '0', STR_PAD_LEFT);
            if (!isset($usersByMonth[$monthKey])) {
                $usersByMonth[$monthKey] = 0;
            }
        }

        ksort($usersByMonth);

        return view('Admin.user.index', compact(
            'totalUsers',
            'totalAdmins',
            'totalClients',
            'newUsersThisMonth',
            'recentUsers',
            'usersByMonth'
        ));
    }
}
