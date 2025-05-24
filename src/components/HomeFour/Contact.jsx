import React from 'react';
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
                                        <h2>Services that help our customers meet</h2>
                                        <div className="text">We strongly support best practice sharing across our operations around the world and across various transporation sectors. Lorem ipsum dolor sit am adipi we help you ensure everyone</div>
                                    </div>
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-011-hand-drill"></i>
                                            <div className="content">
                                                <h5 className="title">Expert Electricians</h5>
                                                <div className="text">We strongly support best practice sharing across our operations around operations around the world</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="feature-block-two">
                                        <div className="inner-box"> <i className="icon flaticon-017-wrench"></i>
                                            <div className="content">
                                                <h5 className="title">Quality Services</h5>
                                                <div className="text">We strongly support best practice sharing across our operations around operations around the world</div>
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
                                        <form method="post" action="get" id="contact-form">
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
                                                    <div className="range-slider-one">
                                                        <input type="text" className="range-amount" name="field-name" />
                                                        <div className="distance-range-slider"></div>
                                                    </div>
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
