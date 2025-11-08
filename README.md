# 🧩 Axproo CoreLib — CORS Filter Plugin pour CodeIgniter 4

**Axproo CoreLib** est un plugin Composer pour **CodeIgniter 4** qui installe automatiquement un **filtre CORS (Cross-Origin Resource Sharing)** dans votre application.
Ce filtre permet de gérer la communication entre votre backend CodeIgniter et des frontends externes (par exemple, Vue.js, React, etc.), en respectant les règles de sécurité CORS.

## 🚀 Installation

Ajoutez simplement la dépendance via Composer :

```bash
composer require axproo/core-lib
```

💡 Composer installera automatiquement le plugin et exécutera le script d’installation (Axproo\CoreLib\Installer::install) pour ajouter le filtre CORS à votre configuration CodeIgniter.

## ⚙️ Configuration automatique

Lors de l’installation :

* Le filtre **Cors** est ajouté dans app/Config/Filters.php :

```php
public array $aliases = [
    'cors' => \App\Filters\Cors::class,
];
```

* Si vous utilisez des routes API, vous pouvez l’activer globalement ou par groupe.

## 🧠 Utilisation

1️⃣ Activer le filtre globalement

Dans app/Config/Filters.php :

```php
public array $globals = [
    'before' => ['cors'],
    'after'  => [],
];
```

2️⃣ Ou l’activer sur un groupe de routes

Dans app/Config/Routes.php :

```php
$routes->group('api', ['filter' => 'cors'], static function ($routes) {
    $routes->get('users', 'Api\UserController::index');
});
```

## 🔧 Exemple de configuration CORS

Par défaut, le filtre autorise les origines suivantes :

```php
protected $allowOrigins = [
    "http://localhost:5173", // Client local
    "https://sandbox.domain.com" // Client distant
];
```

Pour en ajouter d’autres, modifiez simplement la propriété $allowOrigins dans :

```swift
vendor/axproo/core-lib/src/Filters/Cors.php
```

ou bien copiez ce fichier dans votre app/Filters si vous souhaitez le personnaliser.

## 🧩 Contenu du package

```bash
axproo/core-lib/
├── composer.json
├── src/
│   ├── Filters/
│   │   └── Cors.php
│   ├── Installer.php
│   └── Plugin.php
└── README.md
```

* **Cors.php** → Le filtre CodeIgniter gérant les en-têtes CORS.
* **Installer.php** → Le script exécuté après installation/mise à jour.
* **Plugin.php** → Classe plugin Composer pour l’activation automatique.

## 🧑‍💻 Auteur

Christian DJOMOU

📧 <developper@axproo.com>
🌐 <https://axproo.com>

## 📜 Licence

Distribué sous licence MIT.
Vous êtes libre d’utiliser, modifier et redistribuer ce code avec mention d’attribution.

## 🏗️ Exemple de log d’installation

Lors d’un composer require axproo/core-lib, vous devriez voir dans votre terminal :

```php
> Axproo\CoreLib\Installer::install
✅ Axproo CoreLib installé avec succès.
➡ Filtre 'cors' ajouté dans app/Config/Filters.php.
```
