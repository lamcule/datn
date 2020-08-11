#create schema
```sql
create database svf default charset utf8mb4 default collate utf8mb4_unicode_ci;
grant all privileges on svf.* to 'svf'@'localhost' identified by 'svf@123';
grant all privileges on svf.* to 'svf'@'%' identified by 'svf@123';
```
###Step to init project
1.`migrate db`    
```
docker-compose artisan migrate
```
2.`create permission` 
```
docker-compose artisan admin:gerenate-permission-route
```
3.`create super admin account` 
```
docker-compose artisan admin:create-root-user linhpv@gmail.com 1
email: linhpv@gmail.com
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

docker-compose artisan theme:publish backend
```
4.`login to admin`
```
http://127.0.0.1:8902/admin
```

### Tạo Entity
1.`chạy lệnh`
```
docker-compose artisan module:entity:scaffold Student Admin
```
2.`khai bao route`
```
khai bao route trong Admin/Routes/
```
3.`chạy lệnh sinh permission`
```
docker-compose artisan admin:gerenate-permission-route
```
4.` vào admin gán quyền vào role`
5. `generate phpDoc for entities`
```
./dcp artisan ide-helper:models --dir="modules/Mon/Entities"
```
