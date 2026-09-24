<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <header class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-500">Bienvenue</p>
                    <h1 class="text-3xl font-bold">{{ auth()->user()->name ?? 'Utilisateur' }}</h1>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </header>

        <main class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">Utilisateurs</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\User::count() }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">Statut</p>
                <p class="text-3xl font-bold mt-2 text-emerald-600">En ligne</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                <p class="text-sm text-slate-500">Email</p>
                <p class="text-lg font-semibold mt-2 break-all">{{ auth()->user()->email }}</p>
            </div>
        </main>

        <section class="mt-8 bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h2 class="text-xl font-bold mb-4">Activité récente</h2>
            <div class="space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span>Connexion réussie</span>
                    <span class="text-sm text-slate-500">Aujourd’hui</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span>Profil vérifié</span>
                    <span class="text-sm text-slate-500">Aujourd’hui</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Tableau de bord ouvert</span>
                    <span class="text-sm text-slate-500">À l’instant</span>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
