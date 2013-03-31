<?php
class Flickr {

	private $flickr_key;
	private $flickr_secret;
	private $format;

	public function __construct( $flickr_key, $flickr_secret, $format ) {

		$this->flickr_key = $flickr_key;
		$this->flickr_secret = $flickr_secret;
		$this->format = $format; //json
	}

	public function searchPhotos( $query = '' ) {

		$url  = 'http://api.flickr.com/services/rest/?';
		$url .= 'method=flickr.photos.search';
		$url .= '&tags=' . urlencode( $query );

		$url .= '&api_key=' . $this->flickr_key;
		$url .= '&format=' . $this->format;

		$result = @file_get_contents( $url );


		$json = substr( $result, strlen( "jsonFlickrApi(" ), strlen( $result ) - strlen( "jsonFlickrApi(" ) - 1 );

		$data = json_decode( $json, true );
		$photos = $data['photos']['photo'];

		return $photos;
	}

	public function userPhotos( $user_id = '' ) {

		$url  = 'http://api.flickr.com/services/rest/?';
		$url .= 'method=flickr.activity.userPhotos';


		$url .= '&api_key=' . $this->flickr_key;
		$url .= '&format=' . $this->format;
		$url .= '&user_id=' . $user_id;

		$result = @file_get_contents( $url );

		$json = substr( $result, strlen( "jsonFlickrApi(" ), strlen( $result ) - strlen( "jsonFlickrApi(" ) - 1 );

		$data = json_decode( $json, true );
		$photos = $data['photos']['photo'];

		return $photos;
	}

	public function get_signature( $frob ) {

		$signature = md5( $this->flickr_secret . 'api_key' . $this->flickr_key . 'frob' . $frob . 'methodflickr.auth.getToken' );
		return $signature;
	}

	public function get_authsignature( $auth_token, $method ) {

		$signature = md5( $this->flickr_secret .'api_key'. $this->flickr_key .'auth_token'. $auth_token . 'method' . $method );
		return $signature;
	}

	public function getAuthToken( $frob, $signature ) {

		$url  = 'http://api.flickr.com/services/rest/?';
		$url .= 'method=flickr.auth.getToken';
		$url .= '&api_key=' . $this->flickr_key;
		$url .= '&frob=' . $frob;
		$url .= '&api_sig=' . $signature;

		$result = @file_get_contents( $url );
		return $result;
	}

	public function activityUserPhotos( $auth_sign, $auth_token ) {

		$url = 'http://api.flickr.com/services/rest/?';
		$url .= 'method=flickr.people.getPhotos';
		$url .= '&api_key=' . $this->flickr_key;
		$url .= '&auth_token=' . $auth_token;
		$url .= '&api_sig=' . $auth_sign;
		$url .= '&user_id=me';
		$url .= '&format=' . $this->format;

		$result = @file_get_contents( $url );
		$json = substr( $result, strlen( "jsonFlickrApi(" ), strlen( $result ) - strlen( "jsonFlickrApi(" ) - 1 );

		$data = json_decode( $json, true );
		$photos = $data['photos']['photo'];
		return $photos;
	}
}


?>
