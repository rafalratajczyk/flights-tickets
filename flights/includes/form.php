<form action="pdf.php" method="POST">
    <div class="form-group"><br>
        <label>Departure<select name="departure">
                <?php

                $count = count($airports);

                for ($i = 0; $i < $count; $i++) {
                    echo "<option value = '$i' >" . $airports[$i]['name'] . "</option>";
                }

                ?>
            </select></label>
        <br>
        <label>Arrival<select name="arrive">
                <?php

                $count = count($airports);

                for ($i = 0; $i < $count; $i++) {
                    echo "<option value = '$i' >" . $airports[$i]['name'] . "</option>";
                }

                ?>

            </select></label><br>
        <label>Time<input type="datetime-local" name="time"><br></label>
        <label>Flights length<input type="number" min="0" step="1" name="flight"><br></label>
        <label>Price<input type="number" name="price"><br><br></label>
    </div>
    <button type="submit" class="btn btn-primary">Send</button>
</form>
