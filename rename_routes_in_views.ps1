$files = Get-ChildItem -Path "resources/views/subadmin", "resources/views/layouts" -Filter *.blade.php -Recurse
foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $newContent = $content -replace "route\('admin-cabang\.", "route('subadmin."
    $newContent = $newContent -replace "request\(\)->routeIs\('admin-cabang\.", "request()->routeIs('subadmin."
    $newContent = $newContent -replace "routeIs\('admin-cabang\.", "routeIs('subadmin."
    
    # Fix the ID parameter issue in show.blade.php
    if ($file.Name -eq "show.blade.php" -and $file.FullName -like "*pendaftaran*") {
        $newContent = $newContent -replace "\$pendaftaran->id\)", "\$pendaftaran->id_pendaftaran)"
    }

    if ($content -ne $newContent) {
        $newContent | Set-Content $file.FullName
        Write-Host "Updated: $($file.FullName)"
    }
}
