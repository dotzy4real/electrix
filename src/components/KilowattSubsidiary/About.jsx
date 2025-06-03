import React from 'react';
import { Link } from 'react-router-dom';
import AboutImg1 from '../../assets/images/kilowatt/about1.jpg';
import AboutImg2 from '../../assets/images/kilowatt/about2.jpg';

function About({ className }) {
    return (
        <>
            <section className={`about-section-five ${className || ''}`}>
                <div className="shape-23 bounce-y"/>
                <div className="auto-container kilowatt">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title kilowatt">
                                    <span className="sub-title">WHO WE ARE</span>
                                    <h2>Our goal is ensure best electrical accessibility.</h2>
                                    <div className="text">Kilowatt Engineering Limited (KEL) powers lives and businesses with innovation and an unwavering drive for excellence, driven by a mission to redefine customer experience, spend reduction and sustainability while being the provider of choice wherever energy is consumed. 
                                    <br/><br/>
                                    KEL provides end-to-end  Utility Management solutions, from program conceptualization to design, procurement, construction, commissioning, operations, maintenance and management of electric power system, with added expertise of the repairs and maintenance electrical equipment.  

                                    </div>
                                </div>
                                {/*<ul className="list-style-three">
                                    <li>How to Benefited G Shop</li>
                                    <li>electrik other Services</li>
                                    <li>product making for friendly users</li>
                                    <li>We maintaining Safety</li>
                                </ul>*/}
                                <div className="btn-box">
                                    <Link to="/page-about" className="theme-btn btn-style-one bg-dark"><span className="btn-title">DISCOVER MORE</span></Link>
                                    <a href="tel:11(0000)1111" className="info-btn"> <i className="icon fa fa-phone"></i> <small>Call Anytime</small> <strong>07055990710                                    </strong> </a>
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
