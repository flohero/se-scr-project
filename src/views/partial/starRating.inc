<fieldset class="rating">
    <label>
        <input type="radio" name="score"
               value="1" <?php echo isset($data["score"]) && $data["score"] == 1 ? "checked" : "" ?>/>
        <span class="icon">★</span>
    </label>
    <label>
        <input type="radio" name="score"
               value="2" <?php echo isset($data["score"]) && $data["score"] == 2 ? "checked" : "" ?>/>
        <span class="icon">★</span>
        <span class="icon">★</span>
    </label>
    <label>
        <input type="radio" name="score"
               value="3" <?php echo isset($data["score"]) && $data["score"] == 3 ? "checked" : "" ?>/>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
    </label>
    <label>
        <input type="radio" name="score"
               value="4" <?php echo isset($data["score"]) && $data["score"] == 4 ? "checked" : "" ?>/>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
    </label>
    <label>
        <input type="radio" name="score"
               value="5" <?php echo isset($data["score"]) && $data["score"] == 5 ? "checked" : "" ?>/>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
        <span class="icon">★</span>
    </label>
</fieldset>
