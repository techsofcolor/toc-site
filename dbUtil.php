<?php

	// Update Entry
	function updateEntry($entryId,$address1,$address2,$city,$state,$zip,$directions) {

	  $qExists = "SELECT * FROM directory_entry WHERE id='$entryId'";
	  $qUpdate = "UPDATE directory_entry SET address1='$address1', address2='$address2', city='$city', state='$state', zip_code='$zip', driving_directions='$directions', change_timestamp = NOW() WHERE member_id='$uid'";
		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$address_exists = mysql_query($qExists);

	if (mysql_num_rows($address_exists) > 0) {
		$update = mysql_query($qUpdate);
		return 1;
	} else {
        return $this->add_address($uid,$address1,$address2,$city,$state,$zip,$directions);
	}


	} // End: function updateEntry

	// Update Provider
	function updateProvider($providerId, $companyName, $address1, $address2, $city, $state,
												$zip, $primaryPhone, $secondaryPhone, $fax, $nextel,
												$email, $contactName, $url, $logoFilename, $photo1Filename,
												$photo2Filename, $photo3Filename, $photo4Filename, $summary ) {

	  $qExists = "SELECT * FROM service_provider WHERE id='$providerId'";
	  $qUpdate = "UPDATE service_provider SET company_name='$companyName', 
	  			address1='$address1', address2='$address2', city='$city', state='$state', 
	  			zip='$zip', primary_phone='$primaryPhone', secondary_phone='$secondaryPhone',
	  			fax='$fax', nextel='$nextel', email='$email', contact_name='$contactName',
	  			url='$url', logo_filename='$logoFilename', photo1_filename='$photo1Filename',
	  			photo2_filename='$photo2Filename', photo3_filename='$photo3Filename', 
	  			photo4_filename='$photo4Filename', summary='$summary', change_timestamp = NOW() WHERE id='$providerId'";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$provider_exists = mysql_query($qExists);

		if (mysql_num_rows($provider_exists) > 0) {
			$update = mysql_query($qUpdate);
			return $update;
		} else {
		  return 0;
		}

	} // End: function updateProvider

	// Update Service
	function updateService($serviceId, $serviceName) {

	  $qExists = "SELECT * FROM service WHERE id='$serviceId'";
	  $qUpdate = "UPDATE service SET label='$serviceName', change_timestamp = NOW() WHERE id='$serviceId'";
		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$service_exists = mysql_query($qExists);

		if (mysql_num_rows($service_exists) > 0) {
			$update = mysql_query($qUpdate);
			return 1;
		} else {
		  return 0;
		}

	} // End: function updateService

	// Delete Provider
	function deleteProvider($id) {
		$qDelete = "DELETE FROM service_provider WHERE id='$id'";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qDelete);

		return mysql_error();

	} // End: function deleteProvider

	// Delete Service
	function deleteService($id) {
		$qDelete = "DELETE FROM service WHERE id='$id'";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qDelete);

		return mysql_error();

	} // End: function deleteService

	// Delete Entry
	function deleteEntry($id) {
		$qDelete = "DELETE FROM directory_entry WHERE id='$id'";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);
		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qDelete);

		return mysql_error();

	} // End: function deleteEntry

	// ADD Provider
	function addProvider(	$companyName, $address1, $address2, $city, $state,
												$zip, $primaryPhone, $secondaryPhone, $fax, $nextel,
												$email, $contactName, $url, $logoFilename, $photo1Filename,
												$photo2Filename, $photo3Filename, $photo4Filename, $summary ) {
													
		$qUserExists = "SELECT * FROM service_provider WHERE company_name='$companyName'";
		$qInsertProvider = "INSERT INTO service_provider(id,	company_name, address1, address2, 
																									city, state, zip, primary_phone, secondary_phone, 
																									fax, nextel, email, contact_name, url, change_timestamp,
																									rating, num_votes, logo_filename, photo1_filename,
																									photo2_filename, photo3_filename, photo4_filename,
																									summary)
				  			   VALUES ('','$companyName', '$address1', '$address2', '$city', '$state', '$zip', '$primaryPhone', 
				  			   					'$secondaryPhone', '$fax', '$nextel', '$email', '$contactName', '$url',
				  			   					NOW(), 0, 0, '$logoFilename', '$photo1Filename', '$photo2Filename', '$photo3Filename',
				  			   					'$photo4Filename', '$summary')";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);

		// Check if all fields are filled up
		if (trim($companyName) == "") {
			return "Blank company name";
		}

		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qInsertProvider);

		return "";

	} // End: function addProvider

	// ADD Entry
	function addEntry($serviceId, $providerId, $entryDate, $expirationDate, $entryLevel) {
													
		$qInsertEntry = "INSERT INTO directory_entry(service_id, provider_id, entry_date, 
																									expiration_date, entry_level, change_timestamp)
				  			   VALUES ('$serviceId', '$providerId', '$entryDate', '$expirationDate',  
				  			   					'$entryLevel', NOW())";

		$connection = mysql_connect($dbhost, $dbusername, $dbpass);

		// Check if all fields are filled up
		if (trim($entryDate) == "") {
			return "Blank entry date";
		}
		
		if (trim($expirationDate) == "") {
			return "Blank expiration date";
		}

		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qInsertEntry);

		return "";
	
	} // End: function addEntry


	// ADD Service
	function addService($serviceName) {
													
		$qInsertEntry = "INSERT INTO service VALUES ('','$serviceName', NOW())";
		$connection = mysql_connect($dbhost, $dbusername, $dbpass);

		// Check if all fields are filled up
		if (trim($serviceName) == "") {
			return "Blank service name";
		}
		
		$SelectedDB = mysql_select_db($dbname);
		$result = mysql_query($qInsertEntry);

		if (mysql_affected_rows($result) > 0) {
			return mysql_error();
		} else {
		  return "";
		}

		return "";
	
	} // End: function addService

?>