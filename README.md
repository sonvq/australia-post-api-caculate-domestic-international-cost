# australia-post-api-caculate-domestic-international-cost
A PHP Sample to caculate domestic and international cost using Australia Post API

Useful link: 

https://developers.auspost.com.au/apis/pac/tutorial/domestic-parcel

https://developingweb.com.au/blog/2013/09/australia-post-api-and-php/

https://developers.auspost.com.au/apis/pac/reference

https://developers.auspost.com.au/apis

Another way is from 
https://github.com/wp-e-commerce/WP-e-Commerce/blob/master/wpsc-shipping/australiapost.php

For example this: https://auspost.com.au/parcels-mail/calculate-postage-delivery-times/#/option/domestic/3000/2000
is combined of
http://drc.edeliver.com.au/ratecalc.asp?Service_Type=EXPRESS&Pickup_Postcode=3000&Destination_Postcode=2000&Length=105&Width=10&Height=10&Weight=10
and
http://drc.edeliver.com.au/ratecalc.asp?Service_Type=STANDARD&Pickup_Postcode=3000&Destination_Postcode=2000&Length=105&Width=10&Height=10&Weight=10
