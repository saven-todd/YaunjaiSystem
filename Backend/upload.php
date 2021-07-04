<?php

if ( 0 < $_FILES['p_img']['error'] ) {
	echo 'Error: ' . $_FILES['file']['error'] . '<br>';
}
else {
	move_uploaded_file($_FILES['p_img']['tmp_name'], '../IMG/profile/' . $_FILES['p_img']['name']);
	echo 'success';
}