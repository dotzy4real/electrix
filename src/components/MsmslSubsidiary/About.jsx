import React from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/resource/about1-thumb2.jpg';
import AboutImg1 from '../../assets/images/msmsl/about1.jpg';
import AboutImg2 from '../../assets/images/msmsl/about2.jpg';

function About({ className }) {
    return (
        <>
            <section className={`about-section-eight style-two ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="sub-title">WHO WE ARE</span>
                                    <h2>We provide best Metering Solution in town.</h2>
                                    <div className="text">Metering Solutions Manufacturing Services Limited (MSMSL) is an indigenous manufacturing and services company commissioned in September, 2017. Based in Onna, Akwa Ibom State, Nigeria, MSMSL currently boasts an ultra modern, 20,580sqm state-of-the-art assembly and manufacturing facility, with an installed capacity of three (3) million meters per annum.
                                        <br/><br/>
The facility produces high-tech smart and non-smart pre-paid electricity meters and meter boxes used in power measurement and revenue assurance locally and within the African region.
</div>
                                </div>
                                {/*
                                <ul className="list-style-two">
                                    <li><i className="fa fa-check-circle"></i> Deliver Perfect Solution for business</li>
                                    <li><i className="fa fa-check-circle"></i> Readily Work With Global Brands solutions.</li>
                                    <li><i className="fa fa-check-circle"></i> Residential Business Installation</li>
                                </ul>*/}

                                <div className="btn-box">
                                    <div className="founder-info">
                                        <div className="thumb"><img src={AboutThumbImg} alt="Image"/></div>
                                        <h5 className="name">Tolu Ogunkolade</h5>
                                        <span className="designation">General Manager</span>
                                    </div>
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></Link>
                                </div>
                            </div>
                        </div>
                        <div className="image-column col-xl-6 col-lg-5">
                            <div className="inner-column wow fadeInLeft">
                                <figure className="image-1 overlay-anim wow fadeInUp"><img src={AboutImg1} alt="Image"/></figure>
                                <figure className="image-2 overlay-anim wow fadeInRight"><img src={AboutImg2} alt="Image"/></figure>
                                <div className="experience bounce-y">
                                    <div className="inner">
                                        <i className="icon flaticon-023-telephone-socket"></i>
                                        <div className="text"><strong>30+</strong> Years of <br />experience</div>
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
