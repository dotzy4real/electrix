import React from 'react';
import { Link } from 'react-router-dom';
import AboutImg1 from '../../assets/images/resource/about5-1.jpg';
import AboutImg2 from '../../assets/images/resource/about5-2.jpg';

function About({ className }) {
    return (
        <>
            <section className={`about-section-five ${className || ''}`}>
                <div className="shape-23 bounce-y"/>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="sub-title">WHO WE ARE</span>
                                    <h2>Our goal is ensure best electrical accessibility.</h2>
                                    <div className="text">Electrica in a powerful way of just not an only professions, however, in a passion for our Company. We have to a tendency to believe the idea that smart looking of any website</div>
                                </div>
                                <ul className="list-style-three">
                                    <li>How to Benefited G Shop</li>
                                    <li>electrik other Services</li>
                                    <li>product making for friendly users</li>
                                    <li>We maintaining Safety</li>
                                </ul>
                                <div className="btn-box">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
                                    <a href="tel:11(0000)1111" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>11 ( 0000 ) 1111</strong> </a>
                                </div>
                            </div>
                        </div>
                        <div className="image-column col-xl-6 col-lg-5">
                            <div className="inner-column">
                                <figure className="image-1 overlay-anim wow fadeInUp"><img src={AboutImg1} alt="Image"/>
                                </figure>
                                <figure className="image-2 overlay-anim wow fadeInRight"><img src={AboutImg2} alt="Image"/>
                                </figure>
                                <div className="experience bounce-y">
                                    <strong>30+</strong>
                                    <div className="text">Years Work Experience</div>
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
