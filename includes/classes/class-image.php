<?php 

	class JSJGallerySlideshowImage {

        private $all_sizes;

        public function __construct( $attachment_id, $image_size = false ){

            global $_wp_additional_image_sizes; 

            $this->all_sizes = get_intermediate_image_sizes();

            // Populate variables
            $this->attachment_id = $attachment_id;
            $this->image_size = (isset($image_size)) ? $image_size : 'large' ;
            $this->galleries = array();

            // Get Metadata
            $this->metadata = $this->getMetadata();

            $this->attributes = array(
				'id' => 'attachment-image-' . $this->attachment_id
			);

            // Get Sizes
            $this->sizes = $this->getAllSizes(); 

            // Get Image URL
            $this->url = $this->getUrl($this->image_size);
        }

        /**
         * Get Main Image Url
         *
         * @return string
         */
        public function getUrl( $size = false){
            if( !isset( $size ) || $size === false ){
                $size = 'large';
            }
            $url = wp_get_attachment_image_src(
                $this->attachment_id,
                $size
            );
            return $url[0];
        }

        /**
         * Get Image HTML
         *
         * @return <string>
         */
        public function getHtml($image_size = false) {
        	if(!$image_size) {
        		$image_size = $this->image_size;
        	}
        	return wp_get_attachment_image( $this->attachment_id, $image_size, false, $this->attributes);
        }

        /**
         * Get all image sizes and all urls
         *
         * @return array
         */ 
        public function getAllSizes(){
            $sizes = (object) array(); 
            foreach( $this->all_sizes as $image_size ){
                $sizes->{$image_size} = $this->getUrl($image_size);
            }
            return $sizes; 
        }

        /** 
         * Get Image Metadata
         *
         * @return object
         */
        public function getMetadata(){
            return wp_prepare_attachment_for_js( $this->attachment_id ); 
        }

        /**
         * Append a gallery id to the galleries in which this image is present
         *
         * @return <void>
         */
        public function appendGallery($gallery_id){
        	array_push($this->galleries, $gallery_id);
        }
    }