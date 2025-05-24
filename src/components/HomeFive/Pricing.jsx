import React from 'react';
import { Link } from 'react-router-dom'; 
import PricingImage1 from '../../assets/images/resource/pricing-1.png';
import PricingImage2 from '../../assets/images/resource/pricing-2.png';

function Pricing({ className }) {
    return (
        <>
            <section className={`pricing-section style-two ${className || ''}`}>
                <div className="bg bg-pattern-8"/>
                <div className="auto-container">
                    <div className="row align-items-center">
                        <div className="pricing-column col-xl-7 order-2">
                            <div className="inner-column wow fadeInLeft">
                                <div className="pricing-block">
                                    <div className="inner-box">
                                        <figure className="image"><img src={PricingImage2} alt="Image"/></figure>
                                        <h4 className="title">Residential Plan</h4>
                                        <div className="price-box">
                                            <h4 className="price"><sup>$</sup>49</h4>
                                            <span className="validaty">/ MONTLY</span>
                                        </div>
                                        <ul className="features">
                                            <li>Indoor Lighting Installation</li>
                                            <li>Appliance & Fixture Installation</li>
                                            <li>Ceiling Fan Installation</li>
                                            <li>New & Replacement Wiring</li>
                                        </ul>
                                        <div className="btn-box">
                                            <Link to="/page-pricing" className="theme-btn btn-style-one bg-light"><span className="btn-title">BOOKING NOW</span></Link>
                                        </div>
                                    </div>
                                </div>
                                <div className="pricing-block style-two pull-left">
                                    <div className="inner-box">
                                        <figure className="image"><img src={PricingImage1} alt="Image"/></figure>
                                        <h4 className="title">Basic Plan</h4>
                                        <div className="price-box">
                                            <h4 className="price"><sup>$</sup>29</h4>
                                            <span className="validaty">/ MONTLY</span>
                                        </div>
                                        <ul className="features">
                                            <li>Indoor Lighting Installation</li>
                                            <li>Appliance & Fixture Installation</li>
                                            <li>Ceiling Fan Installation</li>
                                            <li>New & Replacement Wiring</li>
                                        </ul>
                                        <div className="btn-box">
                                            <Link to="/page-pricing" className="theme-btn btn-style-one bg-dark"><span className="btn-title">BOOKING NOW</span></Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="content-column col-xl-5 order-xl-2">
                            <div className="inner-column wow fadeInRight">
                                <div className="sec-title">
                                    <span className="sub-title">PRICING OPTIONS</span>
                                    <h2>Our Electrician Pricing Plans.</h2>
                                    <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien  inceptos.</div>
                                </div>
                                <div className="info-btn">
                                    <Link to="tel:+01(2345)6789" className="info-btn-two">
                            <i className="icon fa fa-phone"></i>
                            <small>Call Anytime</small>
                            <strong>+ 01 ( 2345 ) 6789</strong>
                            </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Pricing;