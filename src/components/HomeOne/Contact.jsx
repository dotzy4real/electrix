import React from 'react';
import RangeSlider2 from '../../lib/RangeSlider2.jsx';
import ContactBgImage from '../../assets/images/background/3.jpg';
import ContactBgImage1 from '../../assets/images/background/4.jpg';


function Contact({ className }) {
    return (
        <>
            <section id="contact" className={`contact-section ${className || ''}`}>
                <div className="bg bg-image" style={{ backgroundImage: `url(${ContactBgImage})` }}/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row">
                            <div className="content-column col-lg-6 col-md-12 col-sm-12 order-lg-2">
                                <div className="inner-column wow fadeInRight">
                                    <div className="sec-title light">
                                        <span className="sub-title">FEATURES</span>
                                        <h2>Services that meet our customers electrical needs</h2>
                                        <div className="text">We strongly support best practices across our entire operations around the world and across various transporation sectors. Your sincere happiness is our sincere satisfaction.</div>
                                    </div>
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-011-hand-drill"></i>
                                            <div className="content">
                                                <h5 className="title">Expert Electricians</h5>
                                                <div className="text">We have the world best electricians in the world to meet up your electrical needs</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-017-wrench"></i>
                                            <div className="content">
                                                <h5 className="title">Dedicated Team</h5>
                                                <div className="text">We work together as a cross functional team to deliver world best solutions</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="form-column col-lg-6 col-md-12 col-sm-12">
                                <div className="bg bg-image" style={{ backgroundImage: `url(${ContactBgImage1})` }}/>
                                <div className="inner-column">
                                    <div className="contact-form wow fadeInLeft">
                                        <div className="bg bg-pattern-1"></div>
                                        <h3 className="title">Request A Quote</h3>
                                        <form method="get" action="/" id="contact-form">
                                            <div className="row">
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="first_name" placeholder="First Name" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="last_name" placeholder="Last Name" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="email" placeholder="Email" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="phone" placeholder="Phone" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="company" placeholder="Company" required/>
                                                </div>
                                                <div className="form-group col-lg-6 col-md-6">
                                                    <input type="text" name="address" placeholder="Address" required/>
                                                </div>
                                                <div className="form-group col-lg-12">
                                                    <label>Budget Range</label>
                                                    <RangeSlider2/>
                                                </div>
                                                <div className="form-group col-lg-12">
                                                    <textarea name="form_message" className="form-control required" rows="5" placeholder="Message"></textarea>
                                                </div>
                                                <div className="form-group col-lg-12">
                                                    <button type="submit" className="theme-btn btn-style-one hvr-light" name="submit-form"><span className="btn-title">SUBMIT REQUEST</span></button>
                                                </div>
                                            </div>
                                        </form>
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

export default Contact;
