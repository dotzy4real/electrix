import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import VideoBgImage from '../../assets/images/resource/video1.jpg';

function Video({ className }) {
    const [isOpen, setOpen] = useState(false);
    return (
        <>
    <section className={`video-section-four ${className || ''}`}>
	    <div className="auto-container">
	      <div className="outer-box" style={{backgroundImage: `url(${VideoBgImage})` }}>
			<div className="video-box">
              <div className="btn-box">
                <a onClick={() => setOpen(true)} className="play-now lightbox-image" data-fancybox="gallery" data-caption="">
                  <i className="icon fa fa-play" aria-hidden="true"></i>
                </a>
                <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
              </div>
            </div>
	      </div>
	    </div>
	  </section>
        </>
    );
}

export default Video;
