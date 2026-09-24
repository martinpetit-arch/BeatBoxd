<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen text-slate-800">
    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <p class="text-sm uppercase tracking-wide text-slate-500">Mon profil</p>
                    <h1 class="text-3xl font-bold">{{ auth()->user()->name }}</h1>
                </div>

                <a href="{{ route('home') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-700">
                    Retour à l'accueil
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <p class="text-sm text-slate-500">Nom</p>
                    <p class="mt-2 text-xl font-semibold">{{ auth()->user()->name }}</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <p class="text-sm text-slate-500">Email</p>
                    <p class="mt-2 text-xl font-semibold break-all">{{ auth()->user()->email }}</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <p class="text-sm text-slate-500">Compte créé le</p>
                    <p class="mt-2 text-xl font-semibold">{{ auth()->user()->created_at->format('d/m/Y') }}</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5">
                    <p class="text-sm text-slate-500">Statut</p>
                    <p class="mt-2 text-xl font-semibold text-emerald-600">Actif</p>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-8">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</body>
</html>
