import React from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/resource/about1-thumb2.jpg';
import AboutImg1 from '../../assets/images/resource/about3-1.jpg';
import AboutImg2 from '../../assets/images/resource/about3-2.jpg';

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
                                    <h2>We provide best Electric Solution in town.</h2>
                                    <div className="text">Lorem ipsum dolor sit amet, consectetur notted adipisicing elit sed do eiusmod tempor incididunt ut labore et simply free text dolore magna ediet aliqua lonm andhn tempor facilisis sag</div>
                                </div>

                                <ul className="list-style-two">
                                    <li><i className="fa fa-check-circle"></i> Deliver Perfect Solution for business</li>
                                    <li><i className="fa fa-check-circle"></i> Readily Work With Global Brands solutions.</li>
                                    <li><i className="fa fa-check-circle"></i> Residential Business Installation</li>
                                </ul>

                                <div className="btn-box">
                                    <div className="founder-info">
                                        <div className="thumb"><img src={AboutThumbImg} alt="Image"/></div>
                                        <h5 className="name">Jessica brown</h5>
                                        <span className="designation">Founder of company</span>
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
