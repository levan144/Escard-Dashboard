<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .wrapper {
            max-width: 800px;
            margin: 0 auto;
        }
        .header-img {
            background: url('https://dashboard.escard.ge/public/header.jpeg') no-repeat center top;
            background-size: 100% auto; /* Ensures the header is not cut off */
            height: 137px;
            text-align: right;
            background-color: white;

        }
        .content {
            background-color: #fff;
            padding: 0 30px;
        }
        .footer {
            background-color: #ad3d4b;
            border-radius: 20px 20px 0 0;
            padding: 40px 10px;
            text-align: center;
            color: white;
        }
        .store-icons img {
            padding: 0 5px; /* Adjust spacing between icons */
            width: 120px; /* Increased icon size for visibility */
        }
        .contact-info {
            font-size: 11px; /* Smaller font size for contact info */
            color: white;
            text-align: right;
            padding-right: 35px;
        }
        .h1-mobile {
            font-size:2rem;
        }
        .footer h1 {
            font-size:3rem;
        }
        .social-icons img {
            width: 26px; /* Fixed width for social icons */
            filter: invert(1);
        }

        .h3 {
            font-size:24px!important;
        }
        
        .store-icons img {
            width:200px;
        }
        @media only screen and (max-width: 650px) {
            .wrapper {
                width: 100% !important;
                margin: 0 auto;
            }
            .header-img {
                height: 100px; /* Adjusted height for mobile header */
                background-size: cover; /* Change to cover to ensure full visibility */
            }
            .content, .footer {
                padding: 10px; /* Reduced padding for mobile */
            }
            
            .footer h1  {
                text-align:center;
                color:white;
                font-size: 18px!important; /* Smaller font size for headers on mobile */
            }
            .h1-mobile{
                font-size: 17px!important; /* Smaller font size for headers on mobile */
            }
            .store-icons img {
                width: 100px!important; /* Larger icons for better mobile visibility */
            }
            .social-icons img {
                margin: 0 10px; /* Adjusted margin between social icons */
            }
            .contact-info {
                font-size: 9px; /* Even smaller font size for mobile contact info */
            }
            .h3 {
            font-size:16px!important;
        }
        }
    </style>
</head>
<body>
    <table class="wrapper" width="800" border="0" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin:0 auto">
        <tr>
            <td colspan="2" class="header-img"></td>
        </tr>
        <tr>
            <td class="content" valign="top" style="width: 60%;">
                <h1 class="h1-mobile">ჩვენ მივიღეთ თქვენი მოთხოვნა ანგარიშის პაროლის განახლების შესახებ</h1>
                <p>თქვენი ანგარიშის აღსადგენად შეგიძლიათ გამოიყენოთ შემდეგი კოდი:</p>
                <h3>{{$code}}</h3>
		<p>კოდის დაშვებული ხანგრძლივობა არის ერთი საათი შეტყობინების გაგზავნიდან</p>
            </td>
            <td class="content" valign="top" style="width: 40%; padding-bottom:50px;">
                <img src="https://escard.ge/wp-content/uploads/2024/02/mobile_new2.png" alt="ESCARD Mobile App" style="width: 100%; max-width: 320px; height: auto; display: block; margin: auto;">
            </td>
        </tr>
        <tr>
            <td colspan="2" class="footer" style="margin-top:30px;">
                <h1 style="text-align:center; color:white; margin-top:25px;">გადმოწერე<br> <strong>ESCARD</strong>-ის აპი</h1>
                <div class="store-icons">
                    <a href="https://apps.apple.com/us/app/escard/id1673793652"><img src="https://escard.ge/wp-content/uploads/2024/02/appstore.png" alt="App Store"></a>
                    <a href="https://play.google.com/store/apps/details?id=com.cormotion.escard.android"><img src="https://escard.ge/wp-content/uploads/2024/02/google.png" alt="Google Play"></a>
                </div>
                <hr style="width: 90%; border-top: 1px solid white; margin: 20px auto;">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td style="text-align: left; width: 40%; padding-left:30px;">
                            <div class="social-icons">
                                <a href="https://www.facebook.com/escard.community" target="_blank"><img src="https://dashboard.escard.ge/public/email/facebook.png" alt="Facebook" style="filter:invert(1)"></a>
                                <a href="https://www.instagram.com/escard.community/" target="_blank"><img src="https://dashboard.escard.ge/public/email/instagram.png" alt="Instagram"  style="filter:invert(1); margin:0 5px"></a>
                                <a href="https://ge.linkedin.com/company/escard" target="_blank"><img src="https://dashboard.escard.ge/public/email/linkedin.png" alt="LinkedIn"  style="filter:invert(1)"></a>
                            </div>
                        </td>
                        <td colspan="2" class="contact-info">
                            Mob: + 995 599 05 22 66<br>info@escard.ge<br>
                            Copyright @ 2023 Escard. All Rights Reserved
                            <br>
                            <a href="https://escard.ge/ka/privacy-policy/" target="_blank" style="color: white; text-decoration: none;">Privacy</a> | 
                            <a href="https://escard.ge/ka/terms-of-use/" target="_blank" style="color: white; text-decoration: none;">Terms of use</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
