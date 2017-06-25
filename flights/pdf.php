<?php

require_once('includes/airports.php');
require_once('vendor/autoload.php');

use NumberToWords\NumberToWords;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['departure']) &&
        isset($_POST['arrive']) &&
        isset($_POST['time']) &&
        isset($_POST['flight']) &&
        $_POST['price'] > 0
    ) {
        if ($_POST['departure'] != $_POST['arrive']) {

            $arrive = $airports[$_POST['arrive']];
            $departure = $airports[$_POST['departure']];
            $time = $_POST['time'];
            $flight = $_POST['flight'];
            $price = $_POST['price'];

            $arriveTimeZone = $arrive['timezone'];
            $departureTimeZone = $departure['timezone'];

            $arriveDateTime = new DateTime($time, new DateTimeZone($arriveTimeZone));
            $arriveTime = $arriveDateTime->format('d.m.Y H:i:s');

            $departureDateTime = $arriveDateTime->modify('+' . $flight . ' minutes');
            $departureDateTime->setTimezone(new DateTimeZone($departureTimeZone));
            $departureTime = $departureDateTime->format('d.m.Y H:i:s');

            $faker = Faker\Factory::create();
            $name = $faker->name;

            $numberToWords = new NumberToWords();
            $numberTransformer = $numberToWords->getNumberTransformer('pl');
            $priceWords = $numberTransformer->toWords($price);

            $table = '<link rel="stylesheet" href="css.css" type="text/css">

                        <table>
                            <tr>
                                <th id="company" colspan="2" scope="col">Rafał Ratajczyk</th>
                            </tr>
                            <tr>
                                <th class="fontBig" scope="col">From</th>
                                <th class="fontBig" scope="col">To</th>
                            </tr>
                            <tr>
                                <td class="fontMedium">' . $arrive['name'] . '</td>
                                <td class="fontMedium">' . $departure['name'] . '</td>
                            </tr>
                            <tr>
                                <th class="fontBig" scope="col">Departure (local time)</th>
                                <th class="fontBig" scope="col">Arrival (local time)</th>
                            </tr>
                            <tr>
                                <td>' . $departureTime . '</td>
                                <td>' . $arriveTime . '</td>
                            </tr>
                            <tr>
                                <th class="fontBig" colspan="2">Flight time</th>
                            </tr>
                            <tr>
                              <td class="fontMedium" colspan="2">' . $flight . '</td>
                            </tr>
                            <tr>
                                <th class="fontBig" colspan="2">Passanger</th>
                            </tr>
                            <tr>
                                <td class="namePrice" colspan="2">' . $name . '</td>
                            </tr>
                            <tr>
                                <th class="fontBig" colspan="2">Price</th>
                            </tr>
                            <tr>
                                <td class="namePrice" colspan="2">' . $price . ' zł</td>
                            </tr>
                            <tr>
                                <th class="fontBig" colspan="2">Amount in words</th>
                            </tr>
                            <tr>
                                <td class="fontMedium" colspan="2">' . $priceWords . ' złotych</td>
                            </tr>
                        </table>';

            $mpdf = new mPDF();
            $mpdf->WriteHTML($table);
            $mpdf->Output('pdf.pdf', 'D');
        }

        else {
            echo "Departure can't be the same as arrival !";
        }
    }
}

?>