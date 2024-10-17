# Mini Project

Mini project ini dibuat menggunakan Laravel 10

## Preparation

Clone repositori

```bash
  git clone
  cd mini-project
```

## Installation

Install mini-project with composer

```bash
  composer install
```

Copy `.env.example`

Paste di root directory dan rename menjadi `.env`

Generate `APP_KEY`

```bash
  php artisan key:generate
```

Migrasi Database & Seeder

```bash
  php artisan migrate
  php artisan migrate:fresh --seed
```

Running mini-project

```bash
  php artisan serve
```

## API Reference

### Pelanggan

#### Get All data pelanggan

```http
  GET /api/pelanggan
```

#### Get detail pelanggan

```http
  GET /api/pelanggan/${uid}
```

| Parameter | Type     | Description                        |
| :-------- | :------- | :--------------------------------- |
| `uid`     | `string` | **Required**. uid of item to fetch |

#### Create data pelanggan

```http
  POST /api/pelanggan
```

| Body Form Data  | Type           | Description   |
| :-------------- | :------------- | :------------ |
| `nama`          | `string`       | **Required**  |
| `domisili`      | `string`       | **Required**  |
| `jenis_kelamin` | `string, enum` | pria / wanita |

#### Delete pelanggan

```http
  DELETE /api/pelanggan/${uid}
```

| Parameter | Type     | Description                        |
| :-------- | :------- | :--------------------------------- |
| `uid`     | `string` | **Required**. uid of item to fetch |

#### Update data pelanggan

```http
  PUT /api/pelanggan/${uid}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `uid`     | `string` | **Required**. uid of item to update |

| Body Form Data  | Type           | Description   |
| :-------------- | :------------- | :------------ |
| `nama`          | `string`       |               |
| `domisili`      | `string`       |               |
| `jenis_kelamin` | `string, enum` | pria / wanita |

### Barang

#### Get All data barang

```http
  GET /api/barang
```

#### Get detail barang

```http
  GET /api/barang/${kode}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `kode`    | `string` | **Required**. kode of item to fetch |

#### Create data barang

```http
  POST /api/barang
```

| Body Form Data | Type      | Description  |
| :------------- | :-------- | :----------- |
| `nama`         | `string`  | **Required** |
| `kategori`     | `string`  | **Required** |
| `harga`        | `integer` | **Required** |

#### Delete barang

```http
  DELETE /api/barang/${kode}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `kode`    | `string` | **Required**. kode of item to fetch |

#### Update data barang

```http
  PUT /api/barang/${kode}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `kode`    | `string` | **Required**. uid of item to update |

| Body Form Data | Type      | Description  |
| :------------- | :-------- | :----------- |
| `nama`         | `string`  | **Required** |
| `kategori`     | `string`  | **Required** |
| `harga`        | `integer` | **Required** |

### Penjualan

#### Get All data penjualan

```http
  GET /api/penjualan
```

#### Get detail penjualan

```http
  GET /api/penjualan/${nota}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `nota`    | `string` | **Required**. nota of item to fetch |

#### Create data penjualan

```http
  POST /api/penjualan
```

| Body Form Data    | Type     | Description                                    |
| :---------------- | :------- | :--------------------------------------------- |
| `kode_pelanggan`  | `string` | **Required**                                   |
| `barang[0][kode]` | `string` | **Required**, Bisa masukin barang lebih dari 1 |
| `barang[0][qty]`  | `string` | **Required**,                                  |

#### Delete penjualan

```http
  DELETE /api/penjualan/${nota}
```

| Parameter | Type     | Description                         |
| :-------- | :------- | :---------------------------------- |
| `nota`    | `string` | **Required**. nota of item to fetch |
