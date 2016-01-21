<div class="container">
	<div class="col-md-6 animated fadeInRight">
		<form>
			<div class="form-group">
				<label for="q_cat">Category :</label>
				<select id="q_cat" class="form-control" required>
					<option value="0">Select One</option>
					<option>Refinery</option>
					<option>Petrochemicals</option>
					<option>Additives & Cargo</option>
					<option>Catalysts</option>
					<option>Custom</option>
					<option>Oil Field</option>
				</select>
			</div>
			<div class="form-group">
				<label for="q_prod">Product :</label>
				<select id="q_prod" class="form-control" disabled required>
					<option value="0" selected>Select Product</option>
				</select>
			</div>
			<div class="form-group">
				<label for="q_packaging_size">Packaging Size :</label>
				<select id="q_packaging_size" class="form-control" disabled required>
					<option value="0" selected="selected">ANY</option>
			        <option>1</option>
			        <option>5</option>
			        <option>10</option>
			        <option>20</option>
			        <option>25</option>
			        <option>30</option>
			        <option>35</option>
			        <option>40</option>
			        <option>45</option>
			        <option>50</option>
			        <option>100</option>
			        <option>150</option>
			        <option>165</option>
			        <option>170</option>
			        <option>175</option>
			        <option>180</option>
			        <option>185</option>
			        <option>190</option>
			        <option>200</option>
			        <option>220</option>
			        <option>227</option>
			        <option>900</option>
			        <option>1000</option>
			        <option>16000</option>
			        <option>20000</option>
				</select>
				<input type="hidden" id="packaging_code" value="">
			</div>
			<div class="form-group">
				<label for="q_quantity">Quantity :</label>
				<input type="text" class="form-control" id="q_quantity" name="q_quantity" placeholder="Quantity" disabled required>
			</div>
			<div class="form-group">
				<label for="q_price">Available Price :</label>
				<input type="text" class="form-control" id="q_price" name="q_price" placeholder="Quote Price" disabled required>
			</div>
			<div class="form-group">
				<label for="q_remark">Remark :</label>
				<input type="text" class="form-control" id="q_remark" name="q_remark" placeholder="Remark">
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" id="req_q_btn">SUBMIT</button>
			</div>
		</form>
	</div>
</div>