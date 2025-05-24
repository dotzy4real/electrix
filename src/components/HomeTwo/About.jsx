import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import ModalVideo from 'react-modal-video';
import AboutImg1 from '../../assets/images/resource/about1-thumb1.jpg';
import AboutImg2 from '../../assets/images/resource/about1-1.jpg';
import AboutImg3 from '../../assets/images/resource/about1-2.jpg';

function About({ className }) {
     const [isOpen, setOpen] = useState(false);
    return (
        <>
            <section className={`about-section ${className || ''}`}>
                <div className="icon-plane-1"/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row">
                            <div className="content-column col-xl-6 col-lg-6 col-md-12 col-sm-12 order-lg-2">
                                <div className="inner-column">
                                    <div className="sec-title">
                                        <span className="sub-title">WHO WE ARE</span>
                                        <h2>Providing High Quality<br/>Electrical Solution</h2>
                                    </div>
                                    <div className="text two"><Link to="/page-about">Our operations around the world and across various<br/>Electrical  sectors.</Link></div>
                                    <div className="text">With over four decades of experience providing solutions to large-scale enterprises throughout the globe, we offer end-to-end logistics tailored for specific markets.</div>
                                    <div className="bottom-box">
                                        <div className="author-box">
                                            <div className="inner">
                                                <figure className="image"><img src={AboutImg1} alt="Image"/></figure>
                                                <div className="author-info">
                                                    <h6 className="name">Alen Folker</h6>
                                                    <div className="designation">CEO, Electrica</div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul className="list-style-two">
                                            <li><i className="fa fa-arrow-alt-circle-right"></i> Our solutions are tested</li>
                                            <li><i className="fa fa-arrow-alt-circle-right"></i> Leverage experience in shipping</li>
                                            <li><i className="fa fa-arrow-alt-circle-right"></i> Proven, and best-in class.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="image-column col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div className="inner-column">
                                    <div className="image-box">
                                        <figure className="image overlay-anim"><img src={AboutImg2} alt="Image"/></figure>
                                        <figure className="image-2 overlay-anim wow zoomIn" data-wow-delay="300ms"><img src={AboutImg3} alt="Image"/></figure>
                                    </div>
                                    <div className="video-box">
                                        <h6 className="title">Highly specialized, Electic Compliance Team</h6>
                                        <a onClick={() => setOpen(true)} className="play-btn" data-caption="" data-fancybox=""><i className="icon fa fa-play"></i></a>
                                        <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default About;
