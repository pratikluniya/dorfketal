<div class="container">
	<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6 animated bounceInRight">
		<div class="form-group">
			<label for="purpose">Purpose<sup class="required_field">*</sup> : </label>
			<select id="purpose" class="form-control" required>
				<option value="0" selected="selected">Purpose of My request</option>
		        <option>Have a Sales Rep Contact Me</option>
		        <option>Product Information or Sample</option>
		        <option>Safety Data Sheets</option>
		        <option>Supply to Dorf Ketal</option>
		        <option>Other</option>
		    </select>
		</div>
		<div class="form-group">
			<label for="region">Region<sup class="required_field">*</sup> : </label>
			<select id="region" class="form-control" required>
				<option value="0" selected="selected">Select Region</option>
		        <option>North America</option>
		        <option>Latin America</option>
		        <option>Western Europe</option>
		        <option>Eastern Europe & Russia</option>
		        <option>Middle East</option>
		        <option>Africa</option>
		        <option>India</option>
		        <option>South East Asia</option>
		        <option>North East Asia</option>
		        <option>Japan</option>
		        <option>China & Taiwan</option>
		        <option>Australia & New Zealand</option>
		    </select>
		</div>
		<div class="form-group">
			<label for="industry_app">Industry or Application<sup class="required_field">*</sup> : </label>
			<select id="industry_app" class="form-control" required>
				<option value="0" selected="selected">Select Industry or Application</option>
		        <option>Crude Oil Refining - Process Chemicals</option>
		        <option>Oil and Gas Hydraulic Fracturing</option>
		        <option>Ethylene - Process Chemicals</option>
		        <option>Styrene - Process Chemicals</option>
		        <option>Butadiene - Process Chemicals</option>
		        <option>Fuel Treatment Additives</option>
		        <option>Grease and Lubricant Additives</option>
		        <option>Adhesives and Sealants</option>
		        <option>Corrosion Coatings</option>
		        <option>Inks and Coatings</option>
		        <option>PBT Catalysts</option>
		        <option>PET Catalysts</option>
		        <option>Polyol Esterification Catalysts</option>
		        <option>Polyolefin Catalysts</option>
		        <option>Polyurea and Polyurethane</option>
		    </select>
		</div>
		<div class="form-group">
			<label for="fname">First Name<sup class="required_field">*</sup> : </label>
			<input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
		</div>
		<div class="form-group">
			<label for="lname">Last Name<sup class="required_field">*</sup> : </label>
			<input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
		</div>
		<div class="form-group">
			<label for="email">Email<sup class="required_field">*</sup> : </label>
			<input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
		</div>
		<div class="form-group">
			<label for="phone">Phone<sup class="required_field">*</sup> : </label>
			<input type="number" name="phone" id="phone" class="form-control" placeholder="Phone" maxlength="15" onkeypress="return isNumeric(event)" oninput="maxLengthCheck(this)"required>
		</div>
		<div class="form-group">
			<label for="country">Country<sup class="required_field">*</sup> : </label>
			<input type="text" name="country" id="country" class="form-control" placeholder="Country" required>
		</div>
		<div class="form-group">
			<label for="title">Title<sup class="required_field">*</sup> : </label>
			<input type="text" name="title" id="title" class="form-control" placeholder="Title" required>
		</div>
		<div class="form-group">
			<label for="message">Message<sup class="required_field">*</sup> : </label>
			<textarea name="message" id="message" placeholder="Message" class="form-control" required></textarea>
		</div>
		<div class="form-group">
			<button id="submit_query" class="btn btn-primary">SEND</button>
		</div>
	</div>
</div>