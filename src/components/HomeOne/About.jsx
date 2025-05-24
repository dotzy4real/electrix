import React from 'react';
import { Link } from 'react-router-dom';
import AboutImg1 from '../../assets/images/resource/about4.png';

function About({ className }) {
    return (
        <>
            <section className={`about-section-two ${className || ''}`}>
                    <div className="shape-8 bounce-y"/>
                    <div className="auto-container">
                        <div className="outer-box">
                            <div className="row">
                                <div className="image-column col-lg-6 wow fadeInLeft">
                                    <div className="inner-column wow fadeInLeft">
                                        <div className="image-box">
                                            <figure className="image overlay-anim"><img src={AboutImg1} alt="Image"/></figure>
                                        </div>
                                    </div>
                                </div>
                                <div className="content-column col-lg-6 wow fadeInRight" data-wow-delay="300ms">
                                    <div className="inner-column">
                                        <div className="sec-title">
                                            <span className="sub-title">WHO WE ARE</span>
                                            <h2>Africa's Electrical Engineering Solutions Leader</h2>
                                        </div>
                                        <div className="text two">
                                            <Link to="/who-we-are">Our operations span Africa and encompass diverse sectors <br />within the electrical industry.</Link>
                                        </div>
                                        <div className="text">Income Electrix Limited (IEL) operates as a Group of companies  through Strategic Alliances, providing end-to-end electromechanical solutions, from developing Project Concepts through Engineering, Local  & foreign Procurement, Construction, Commissioning, Operations, Maintenance, Manufacturing, Management, and Utility.</div>
                                        <div className="row">
                                            <div className="about-block col-md-6">
                                                <div className="inner"> <i className="icon flaticon-business-030-settings"></i>
                                                    <h5 className="title"><Link to="/who-we-are">Awarded Company</Link></h5>
                                                    <div className="text mb-0">We strongly support best practices across our operations all around.</div>
                                                </div>
                                            </div>
                                            <div className="about-block col-md-6">
                                                <div className="inner mb-0"> <i className="icon flaticon-011-hand-drill"></i>
                                                    <h5 className="title"><Link to="/page-service-details">Flexible & Low Cost</Link></h5>
                                                    <div className="text mb-0">We offer very affordable electrical services with best equipment implementations</div>
                                                </div>
                                            </div>
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
