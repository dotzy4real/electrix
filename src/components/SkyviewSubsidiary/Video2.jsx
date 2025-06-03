import React, { useState } from 'react';
import ModalVideo from 'react-modal-video';
import VideoBgImg from '../../assets/images/background/11.jpg';
import VideoImg from '../../assets/images/background/10.jpg';

function Video({ className }) {
    const [isOpen, setOpen] = useState(false);
    return (
        <>
            <div className={`video-section-two ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${VideoBgImg})`}}/>
                <div className="auto-container">
                    <div className="row align-items-end">
                        <div className="content-column col-xl-5 order-2">
                            <div className="sec-title style-three">
                                <span className="sub-title">OUR BENIFITIES</span>
                                <h2>Why You should <br />Choose us</h2>
                                <div className="text">With over four decades of experience providing <br />solutions to large-scale enterprises throughout the <br />globe, we offer end-to-end.</div>
                            </div>
                            <ul className="list-style-four">
                                <li>Our main goal is simply works for the customers.</li>
                                <li>Strategies to ensure proactive Services.</li>
                                <li>Professional  worldwide methodologies.</li>
                            </ul>
                        </div>
                        <div className="image-column col-xl-7 order-xl-2">
                            <div className="inner-column">
                                <figure className="image mb-0"><img src={VideoImg} alt="Image"/></figure>
                                <div className="video-box">
                                    <div className="btn-box">
                                        <a onClick={() => setOpen(true)} className="play-now lightbox-image" data-fancybox="gallery" data-caption="">
                                            <i className="icon fa fa-play" aria-hidden="true"></i>
                                        </a>
                                        <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
                                    </div>
                                </div>
                                <div className="experience">
                                    <div className="inner">
                                        <i className="icon flaticon-023-telephone-socket"></i>
                                        <h5 title="title">Highly specialized, Craft Compliance Team</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default Video;
