<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- <link rel="stylesheet" href="<?php echo ROOT?>/assets/css/admindashboard.css"> -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px;
        }

        .top {
            text-align: center;
            margin-bottom: 20px;
        }

        .top img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .dash-content {
            display: flex;
            justify-content: center;
        }

        .boxes {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .box {
            background-color: #6a3879;
            color: #fff;
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            width: 200px;
            cursor: pointer;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .box:hover {
            background-color: #2980b9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .text {
            font-size: 18px;
        }

        .number {
            font-size: 24px;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <section class="dashboard">
        <!-- <div class="top">
            <span class="greeting">HI, MANDY!</span>
            <img src="/assets/images/petowner.png" alt="Admin Logo">
        </div> -->
        <div class="dash-content">
            <div class="boxes">
                <div class="box box1">
                    <span class="text">Daycare Bookings</span>
                    <span class="number">16</span>
                </div>
                <div class="box box2">
                    <span class="text">Appointment Bookings</span>
                    <span class="number">24</span>
                </div>
                <div class="box box3">
                    <span class="text">Transport Bookings</span>
                    <span class="number">4</span>
                </div>
                <div class="box box4">
                    <span class="text">Total Users</span>
                    <span class="number">100</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

