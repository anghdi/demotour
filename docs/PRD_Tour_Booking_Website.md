# PRD --- Tour Booking Website

**Versi:** 0.1 --- Prototype\
**Status:** Testing / Demo\
**Platform:** Responsive Web

## 1. Product Overview

Website digunakan oleh bisnis tour untuk menampilkan paket wisata dan
menerima booking secara online.

Tujuan prototype adalah mendemonstrasikan alur customer dari memilih
paket hingga booking dan simulasi pembayaran.

### Main Flow

``` text
Landing Page
↓
Tour Packages
↓
Package Detail
↓
Select Date & Guests
↓
Customer Information
↓
Booking Summary
↓
Payment
↓
Booking Confirmed
```

> Prototype harus terasa seperti website production, tetapi transaksi
> pembayaran masih berupa mock/simulasi.

## 2. User Roles

### Customer

-   Melihat paket dan detail tour
-   Memilih tanggal dan jumlah peserta
-   Mengisi data booking
-   Melakukan simulasi pembayaran
-   Mendapatkan Booking ID
-   Menghubungi admin melalui WhatsApp

### Admin

-   Login
-   Melihat dashboard
-   Melihat daftar dan detail booking
-   Mengubah status booking
-   Melihat status pembayaran

## 3. Landing Page

**Route:** `/`

### Hero

**Headline:** Explore Nusa Penida With Us

**Description:** Discover the best of Nusa Penida with carefully curated
private tours.

CTA: - Explore Tours - WhatsApp Us

### Featured Packages

1.  **West Nusa Penida Tour** --- Kelingking Beach, Broken Beach,
    Angel's Billabong, Crystal Bay --- mulai Rp650.000.
2.  **East Nusa Penida Tour** --- Diamond Beach, Atuh Beach, Tree House,
    Teletubbies Hill --- mulai Rp700.000.
3.  **West + East Nusa Penida** --- Full Day Tour --- mulai Rp950.000.

### Why Choose Us

-   Local Guide
-   Private Tour
-   Easy Booking
-   Secure Payment

Tambahkan gallery destinasi, minimal 3 dummy testimonial, dan CTA akhir
**Explore Tours**.

## 4. Tour Listing

**Route:** `/tours`

Card menampilkan image, nama tour, duration, tour type, starting price,
dan CTA `View Details`.

Prototype cukup menggunakan 3 paket.

## 5. Tour Detail

**Route:** `/tours/[slug]`

Tampilkan: - Hero image dan gallery - Tour name - Rating dummy -
Duration - Starting price - Tour description - Destinations - What's
Included - Not Included - CTA `Book This Tour`

Contoh included: Private Car, Local Driver, Fuel, Parking Fee, Mineral
Water.

## 6. Booking Widget

Customer memilih **Travel Date** menggunakan date picker. Past date
disabled.

Guest selector: - Minimum: 1 - Maximum prototype: 10

Harga dihitung otomatis.

``` text
Rp650.000 × 2 Guests
Total: Rp1.300.000
```

CTA: `Continue Booking`

## 7. Customer Information

**Route:** `/booking/details`

Fields: - Full Name * - Email * - WhatsApp Number * - Country * -
Special Request

CTA: `Continue`

## 8. Booking Summary

**Route:** `/booking/checkout`

Tampilkan customer details, tour, travel date, guest count, price per
guest, total, dan action untuk edit booking.

CTA: `Continue to Payment`

## 9. Payment

**Route:** `/booking/payment`

Prototype tidak menggunakan payment gateway asli.

Payment methods: - Credit / Debit Card - Bank Transfer - QRIS

Untuk kartu, input hanya dummy dan **data kartu tidak boleh diproses
atau disimpan**.

Setelah tombol Pay ditekan: 1. Tampilkan `Processing Payment...` 2.
Delay sekitar 1--2 detik 3. Set mock payment menjadi `PAID` 4. Redirect
ke booking success

## 10. Booking Success

**Route:** `/booking/success`

Tampilkan: - Booking Confirmed - Booking ID - Tour - Date - Guests -
Total - Payment status `PAID`

CTA: - Contact Us on WhatsApp - Back to Home

## 11. WhatsApp Integration

Gunakan link WhatsApp dengan pre-filled message:

``` text
Hi, I have made a booking.

Booking ID: NP-20261012-001
Tour: West Nusa Penida Tour
Date: 12 October 2026

I would like to confirm my booking.
```

Nomor WhatsApp menggunakan environment/config.

## 12. Admin Login

**Route:** `/admin/login`

Fields: - Email - Password

Tidak perlu forgot password untuk prototype.

## 13. Admin Dashboard

**Route:** `/admin`

Summary: - Total Bookings - Upcoming - Completed - Revenue

Tampilkan juga tabel Recent Bookings dengan Booking ID, Customer, Tour,
Date, Total, dan Status.

## 14. Booking Management

**Route:** `/admin/bookings`

Search berdasarkan: - Booking ID - Customer Name

Filter: - All - Pending - Confirmed - Completed - Cancelled

## 15. Booking Detail Admin

**Route:** `/admin/bookings/[id]`

Tampilkan customer information, tour, travel date, guest count, total,
payment status, booking status, dan special request.

Admin dapat mengubah status: - Pending - Confirmed - Completed -
Cancelled

## 16. Data Model

### Tour

``` text
id
name
slug
description
price
duration
image
gallery[]
destinations[]
included[]
excluded[]
active
```

### Booking

``` text
id
booking_code
tour_id
travel_date
guest_count
customer_name
customer_email
customer_whatsapp
customer_country
special_request
subtotal
total
payment_method
payment_status
booking_status
created_at
updated_at
```

## 17. Status

Booking status: - PENDING - CONFIRMED - COMPLETED - CANCELLED

Payment status: - UNPAID - PAID - FAILED - REFUNDED

Prototype cukup mengubah pembayaran menjadi `PAID` setelah mock payment
berhasil.

## 18. Booking ID

Format:

``` text
NP-YYYYMMDD-XXX
```

Contoh: `NP-20261012-001`

## 19. Responsive Requirements

Gunakan pendekatan **Mobile First**.

Target: - Mobile - Tablet - Desktop

Flow booking harus nyaman dari smartphone karena traffic berpotensi
berasal dari Instagram/Meta Ads.

## 20. Design Direction

**Tropical + Premium Travel Website**

Guidelines: - Foto destinasi besar - Banyak whitespace - Typography
bersih - Rounded card secukupnya - Navigasi sederhana - CTA booking
jelas - Animasi/transisi halus - Hindari terlalu banyak gradient -
Hindari semua section berbentuk card - Hindari tampilan generik seperti
template SaaS

## 21. Navigation

Desktop:

``` text
LOGO
Home
Tours
About
Gallery
Contact
[ Book Now ]
```

Mobile:

``` text
LOGO                    ☰
```

## 22. Prototype Scope

### Wajib Dibuat

-   [ ] Landing Page
-   [ ] Tour Listing
-   [ ] Tour Detail
-   [ ] Calendar
-   [ ] Guest Selector
-   [ ] Customer Form
-   [ ] Dynamic Pricing
-   [ ] Booking Summary
-   [ ] Mock Payment
-   [ ] Booking Success
-   [ ] WhatsApp CTA
-   [ ] Admin Login
-   [ ] Admin Dashboard
-   [ ] Booking List
-   [ ] Booking Detail
-   [ ] Responsive Design

### Out of Scope

-   [ ] Real Payment Gateway
-   [ ] Email Automation
-   [ ] WhatsApp API
-   [ ] Google Calendar Integration
-   [ ] Customer Account
-   [ ] Refund System
-   [ ] Coupon
-   [ ] Multi Currency
-   [ ] Multi Language
-   [ ] Real-time Availability
-   [ ] Advanced Analytics

## 23. Definition of Done

``` text
Buka Website
↓
Lihat Paket
↓
Pilih Tour
↓
Pilih Tanggal
↓
Pilih Jumlah Guest
↓
Total Dihitung Otomatis
↓
Isi Data Customer
↓
Review Booking
↓
Mock Payment
↓
Booking Confirmed
↓
Booking Muncul di Admin
```

Acceptance criteria: - Semua halaman utama dapat diakses - Flow booking
berjalan sampai selesai - Harga berubah berdasarkan jumlah guest -
Booking ID dibuat setelah booking berhasil - Mock payment menghasilkan
status `PAID` - Booking berhasil muncul di admin - Admin dapat melihat
detail dan mengubah status booking - WhatsApp CTA menghasilkan
pre-filled message - Tampilan berfungsi baik pada mobile dan desktop

## 24. Prototype Principle

Prototype dibuat untuk **validasi dan demo kepada calon client**, bukan
menggantikan versi production.

Prioritas: 1. Flow booking berfungsi 2. UI terlihat profesional 3.
Mobile experience baik 4. Admin cukup untuk demo pengelolaan booking 5.
Jangan overbuild fitur yang belum dibutuhkan

Setelah prototype tervalidasi, versi production dapat dilanjutkan dengan
payment gateway asli, availability management, notification, dan fitur
operasional lainnya.
