<?php
// Video Post Meta
$fitnase_video_post_meta = 'video_post_format_meta';

CSF::createMetabox( $fitnase_video_post_meta, array(
	'title'        => esc_html__('Video Post Format Options', 'fitnase' ),
	'post_type'    => 'post',
	'post_formats' => array('video'),
) );

CSF::createSection( $fitnase_video_post_meta, array(
	'fields' => array(

		array(
			'id'    => 'post_video_url',
			'type'  => 'text',
			'title' => esc_html__('Video URL', 'fitnase' ),
			'desc'    => esc_html__( 'Paste video URL here', 'fitnase' ),
		),

	)
));

// Audio Post Meta
$fitnase_audio_post_meta = 'audio_post_format_meta';

CSF::createMetabox( $fitnase_audio_post_meta, array(
	'title'        => esc_html__('Audio Post Format Options', 'fitnase' ),
	'post_type'    => 'post',
	'post_formats' => array('audio'),
) );

CSF::createSection( $fitnase_audio_post_meta, array(
	'fields' => array(

		array(
			'id'    => 'audio_embed_code',
			'type'  => 'code_editor',
			'settings' => array(
				'theme'  => 'monokai',
				'mode'   => 'htmlmixed',
			),
			'title' => esc_html__('Audio Embed Code', 'fitnase' ),
			'desc'    => esc_html__( 'Paste sound cloud audio embed code here', 'fitnase' ),
		),

	)
));


// Gallery Post Meta
$fitnase_gallery_post_meta = 'gallery_post_format_meta';

CSF::createMetabox( $fitnase_gallery_post_meta, array(
	'title'        => esc_html__('Gallery Post Format Options', 'fitnase' ),
	'post_type'    => 'post',
	'post_formats' => array('gallery'),
) );

CSF::createSection( $fitnase_gallery_post_meta, array(
	'fields' => array(

		array(
			'id'          => 'post_gallery_images',
			'type'        => 'gallery',
			'title' => esc_html__('Gallery Images', 'fitnase' ),
			'add_title'   => esc_html__('Upload Gallery Images', 'fitnase'),
			'edit_title'  => esc_html__('Edit Gallery Images', 'fitnase'),
			'clear_title' => esc_html__('Remove Gallery Images', 'fitnase'),
			'desc'    => esc_html__( 'Upload gallery images from here', 'fitnase' ),
		),

	)
));