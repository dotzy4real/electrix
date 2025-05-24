import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import VideoBgImg from '../../assets/images/background/27.jpg';
import VideoImg from '../../assets/images/resource/float-img-6.png';

function Video({ className }) {
    const [isOpen, setOpen] = useState(false);
    return (
        <>
            <section className={`video-section-three ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${VideoBgImg})`}}/>
                <div className="overlay-4"/>
                <div className="float-image bounce-x"><img src={VideoImg} alt="Image"/></div>
                <div className="auto-container">
                    <div className="outer-box"><a onClick={() => setOpen(true)} className="play-now-two" data-fancybox="gallery" data-caption=""> <i className="icon fa fa-play" aria-hidden="true"></i> <span className="ripple"></span></a>
                    <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
                        <h2 className="title words-slide-up text-split">Providing best quality <br />courier & Electronics <br />services to all</h2>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Video;
