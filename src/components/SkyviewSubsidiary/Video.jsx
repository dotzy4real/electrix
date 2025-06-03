import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import VideoBgImg from '../../assets/images/background/9.jpg';
import VideoImg from '../../assets/images/icons/icon-arrow-2.png';

function Video({ className }) {
    const [isOpen, setOpen] = useState(false);
    return (
        <>
            <section className={`video-section ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${VideoBgImg})`}}/>
                <div className="overlay-2"/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="title-box">
                            <h2 className="title words-slide-up text-split">Providing Best quality <br />Electrician & Electric <br />Services to all</h2>
                        </div>
                        <div className="video-box">
                            <div className="icon-box">
                                <h4 className="title">Watch Video</h4>
                                <img src={VideoImg} alt="icon"/>
                            </div>
                            <a onClick={() => setOpen(true)} className="play-now-two" data-fancybox="gallery" data-caption=""> <i className="icon fa fa-play" aria-hidden="true"></i> <span className="ripple"></span> </a>
                            <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Video;
