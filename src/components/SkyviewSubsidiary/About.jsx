import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import ModalVideo from 'react-modal-video';
import AboutImg1 from '../../assets/images/resource/about1-thumb1.jpg';
import AboutImg2 from '../../assets/images/skyview/about1.jpg';
import AboutImg3 from '../../assets/images/skyview/about2.jpg';

function About({ className }) {
     const [isOpen, setOpen] = useState(false);
    return (
        <>
            <section className={`about-section ${className || ''}`}>
                <div className="icon-plane-1"/>
                <div className="auto-container skyview">
                    <div className="outer-box">
                        <div className="row">
                            <div className="content-column col-xl-6 col-lg-6 col-md-12 col-sm-12 order-lg-2">
                                <div className="inner-column">
                                    <div className="sec-title skyview">
                                        <span className="sub-title">WHO WE ARE</span>
                                        <h2>Providing High Quality<br/>Electrical Solution</h2>
                                    </div>
                                    {/*<div className="text two"><Link to="/page-about">Our operations around the world and across various<br/>Electrical  sectors.</Link></div>*/}
                                    <div className="text">Skyview Power Technologies Limited is a leading Nigerian engineering solutions provider, delivering expert consultancy and execution across the mechanical and electrical sectors. Established in 2004, we have built over two decades of industry experience grounded in innovation, technical excellence, and a commitment to powering progress.
<br/><br/>
We specialize in the design, installation, and maintenance of electricity transmission systems, whether powered by hydro, gas turbines, diesel, coal, or solar energy. Our capabilities span transmission line networks, transformer sales and servicing, electrical cabling, and complete turnkey project management.{/*}
<br/><br/>
At Skyview, we combine deep engineering expertise with strategic project execution to serve a wide range of public and private sector clients. Our mission is simple: to deliver reliable, efficient, and future-ready power solutions that energize growth and empower infrastructure across Nigeria and beyond.*/}
</div>
                                    {/*<div className="bottom-box">
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
                                    </div>*/}
                                </div>
                            </div>
                            <div className="image-column col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                <div className="inner-column skyview">
                                    <div className="image-box">
                                        <figure className="image overlay-anim"><img src={AboutImg2} alt="Image"/></figure>
                                        <figure className="image-2 overlay-anim wow zoomIn" data-wow-delay="300ms"><img src={AboutImg3} alt="Image"/></figure>
                                    </div>
                                    <div className="video-box">
                                        <h6 className="title">To provide quality products and services that deliver value for money to the customer</h6>
                                        {/*<a onClick={() => setOpen(true)} className="play-btn" data-caption="" data-fancybox=""><i className="icon fa fa-play"></i></a>
                                        <ModalVideo channel='youtube' autoplay isOpen={isOpen} videoId="Fvae8nxzVz4" onClose={() => setOpen(false)} />*/}
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
