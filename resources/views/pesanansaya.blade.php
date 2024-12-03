@extends('layouts.app')
@section('title')
<title>Pesanan Saya - Fishapp</title>
@endsection

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #202020;
      color: #ffffff;
      margin: 0;
      padding: 0;
    }

    .navbar-1 {
      display: flex;
      background-color: #097ABA;
      padding: 10px;
      justify-content: space-around;
      margin-top: 10px;
      margin-left: 120px;
      margin-right: 120px;
    }

    .navbar-1 a {
      color: #000000;
      text-decoration: none;
      padding: 8px 16px;
    }

    .navbar-1 a.active {
      color: #ffffff;
      font-weight: bold;
    }

    .container {
            padding: 20px;
            width: 100%;
            margin: auto;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header .star {
            color: #000000;
            font-weight: bold;
        }
        .header .chat-btn, .header .store-btn {
            background-color: #09AFBA;
            color: #ffffff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .order {
            background-color: #F7F7F7;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .order img {
            width: 100px;
            border-radius: 5px;
        }
        .order-content {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .order-details {
            flex: 1;
            color: #000000;
        }
        .order-details h3 {
            margin: 0 0 10px;
            font-size: 16px;
        }
        .price {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }
        .price .discount {
            text-decoration: line-through;
            color: #979797;
        }
        .price .final-price {
            color: #097ABA;
            font-weight: bold;
        }

        /* Container utama */
        .status {
            display: flex;
            justify-content: end;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #36d399;
        }

        /* Ikon tooltip */
        .tooltip-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 15px;
            height: 15px;
            border: 1px solid #000000;
            border-radius: 50%;
            color: #000000;
            background-color: transparent;
            font-size: 12px;
            cursor: pointer;
        }

        /* Tooltip teks */
        .tooltip-icon .tooltip-text {
            position: absolute;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #252525;
            color: #ffffff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            visibility: hidden;
            opacity: 0;
            transition: opacity 0.2s ease, visibility 0.2s ease;
            z-index: 10;
        }

        /* Segitiga kecil di tooltip */
        .tooltip-icon .tooltip-text::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border-width: 6px;
            border-style: solid;
            border-color: #252525 transparent transparent transparent;
        }

        /* Tampilkan tooltip saat hover */
        .tooltip-icon:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Teks "SELESAI" */
        .completed {
            color: #097ABA;
            font-weight: bold;
        }

  </style>
</head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=local_shipping" />
<body>
  <div class="navbar-1">
    <a href="{{route('pesanansaya.semua')}}">Semua</a>
    <a href="#">Belum Bayar</a>
    <a href="#">Sedang Dikirim</a>
    <a href="#">Selesai</a>
    <a href="#">Dibatalkan</a>
    <a href="#">Pengembalian Barang</a>
  </div>

            <!-- search -->
            <div class="ms-auto p-4 p-lg-0">
                <form class="d-flex ms-auto" id="searchForm" role="search">
                    <div class="input-group" style="max-width: 1280px; width: 100%; margin-top: 10px; margin-left: 120px">
                        <input 
                            class="form-control" 
                            type="search" 
                            placeholder="Search for..." 
                            aria-label="Search"
                            id="searchInput"
                        />
                        <button 
                            class="btn btn-primary" 
                            type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

<!-- detail barang -->
<div class="container">
        <div class="header">
            <span class="star">Pratama Zidan</span>
            <div>
                <button class="chat-btn">Hubungi Penjual</button>
            </div>
        </div>
        <div class="order">
            <div class="order-content">
                <img src="img/pajar.jpg" alt="Produk">
                <div class="order-details">
                <div class="status">
                    <span class="material-symbols-outlined">local_shipping</span>
                    <span>Pesanan tiba di alamat tujuan. diterima oleh Yang bersangkutan.</span>
                    <div class="tooltip-icon">
                        <i class="fas fa-question-circle"></i>
                        <div class="tooltip-text">Terakhir Di Update Pada <br> 28-11-2024 17:10</div>
                    </div>
                    <span class="completed">SELESAI</span>
                </div>

                    <h3>Ikan Tuna</h3>
                    <span>x1</span>
                    <div class="price">
                        <span class="discount">Rp22.500</span>
                        <span class="final-price">Rp20.000</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@include('components.foot')
@endsection

