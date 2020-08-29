```
###Step to init project
1.`migrate db`    
```
php artisan migrate
```
2.`create permission` 
```
php artisan admin:gerenate-permission-route
```
3.`create super admin account` 
```
php artisan admin:create-root-user lamnt@gmail.com 1
email: lamnt@gmail.com
password: 1

```
4.`build theme backend`
```
cd themes/backend
yarn install
yarn run dev
```
5.`publish theme backend`
in root project
```

php artisan theme:publish backend
```
4.`login to admin`
```
http://domain.local/admin
```

### Tạo Entity
1.`chạy lệnh`
```
php artisan module:entity:scaffold Student Admin
```
2.`khai bao route`
```
khai bao route trong Admin/Routes/
```
3.`chạy lệnh sinh permission`
```
php artisan admin:gerenate-permission-route
```
4.` vào admin gán quyền vào role`
