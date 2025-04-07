<style>
    body {
        background: #f8f9fa;
        color: #212529;
    }

    .navbar {
        background: white;
        padding: 12px 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
    }

    .navbar a {
        color: #212529;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .navbar a:hover {
        color: #0d6efd;
    }

    .sidebar {
        width: 250px;
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        position: fixed;
        top: 70px;
        left: 0;
        z-index: 998;
        transition: left 0.3s ease;
        overflow-y: auto;
        bottom: 40px;
        height: auto;
    }

    .sidebar a {
        display: block;
        color: #212529;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 5px;
        text-decoration: none;
        transition: background 0.3s ease;
    }

    .sidebar a:hover {
        background: #2470db;
        color: white;
    }

    .content {
        margin-left: 260px;
        margin-top: 70px;
        padding: 20px;
        min-height: calc(100vh - 110px);
        padding-bottom: 50px;
    }

    .footer {
        background: white;
        text-align: center;
        padding: 10px;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 40px;
        z-index: 999;
    }

    .container-fluid {
        padding-left: 0;
        padding-right: 0;
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
            top: 70px;
            left: -200px;
            bottom: 40px;
        }

        .sidebar.active {
            left: 0;
        }

        .content {
            margin-left: 0;
            min-height: calc(100vh - 110px);
        }

        .navbar {
            padding: 8px 15px;
        }

        .sidebar a {
            font-size: 14px;
        }

        .footer {
            font-size: 12px;
        }

        .navbar .toggle-btn {
            display: block;
        }
    }

    @media (max-width: 576px) {
        .navbar {
            padding: 10px 15px;
        }

        .sidebar {
            width: 100%;
            left: -100%;
            top: 70px;
            bottom: 40px;
        }

        .sidebar.active {
            left: 0;
        }

        .content {
            margin-left: 0;
            margin-top: 70px;
            padding: 15px;
        }
        
        .content.shifted {
            margin-left: 0;
        }

        .footer {
            font-size: 10px;
            padding: 8px;
        }
    }
</style>