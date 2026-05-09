$files = Get-ChildItem -Path "app/Http/Controllers/Subadmin" -Filter *.php
foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $newContent = $content -replace "redirect\(\)->route\('admin-cabang\.", "redirect()->route('subadmin."
    $newContent = $newContent -replace "route\('admin-cabang\.", "route('subadmin."
    
    if ($content -ne $newContent) {
        $newContent | Set-Content $file.FullName
        Write-Host "Updated: $($file.FullName)"
    }
}
