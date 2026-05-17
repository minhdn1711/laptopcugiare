# Import WordPress Database
Write-Host "Dropping and recreating database..." -ForegroundColor Cyan
docker exec -i laptopcugiare_db mysql -u root -proot_password -e "DROP DATABASE IF EXISTS wordpress; CREATE DATABASE wordpress;"

Write-Host "Copying SQL file to container..." -ForegroundColor Cyan
docker cp "C:\Users\Minh 2 TL\Downloads\wordpress.sql" laptopcugiare_db:/tmp/wordpress.sql

Write-Host "Importing SQL file inside container..." -ForegroundColor Cyan
docker exec -i laptopcugiare_db mysql -u root -proot_password wordpress -e "source /tmp/wordpress.sql"

Write-Host "Cleaning up..." -ForegroundColor Cyan
docker exec -i laptopcugiare_db rm /tmp/wordpress.sql

Write-Host "Database import completed!" -ForegroundColor Green

Write-Host "Updating site URLs..." -ForegroundColor Cyan
docker exec -i laptopcugiare_db mysql -u root -proot_password wordpress -e "UPDATE wpx_options SET option_value = 'http://localhost:8088' WHERE option_name IN ('siteurl', 'home');"

Write-Host "Done! You can now visit http://localhost:8088" -ForegroundColor Green
