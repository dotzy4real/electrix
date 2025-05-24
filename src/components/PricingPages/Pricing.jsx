import React from 'react';
import { Link } from 'react-router-dom';

import PricingImage1 from '../../assets/images/resource/pricing-1.png';
import PricingImage2 from '../../assets/images/resource/pricing-2.png';

function Pricing() {
    return (
        <>
            <section className="pricing-section style-two">
                <div className="bg bg-pattern-8"/>
                <div className="auto-container">
                    <div className="row align-items-center">
                        <div className="pricing-column col-xl-7 order-2">
                            <div className="inner-column wow fadeInLeft">
                                {[ 
                                    { image: PricingImage2, title: "Residential Plan", price: 49, theme: "bg-light" },
                                    { image: PricingImage1, title: "Basic Plan", price: 29, theme: "bg-dark" }
                                ].map((plan, index) => (
                                    <div key={index} className={`pricing-block ${index === 1 ? 'style-two pull-left' : ''}`}>
                                        <div className="inner-box">
                                            <figure className="image"><img src={plan.image} alt="Image"/></figure>
                                            <h4 className="title">{plan.title}</h4>
                                            <div className="price-box">
                                                <h4 className="price"><sup>$</sup>{plan.price}</h4>
                                                <span className="validaty">/ MONTHLY</span>
                                            </div>
                                            <ul className="features">
                                                <li>Indoor Lighting Installation</li>
                                                <li>Appliance & Fixture Installation</li>
                                                <li>Ceiling Fan Installation</li>
                                                <li>New & Replacement Wiring</li>
                                            </ul>
                                            <div className="btn-box">
                                                <Link to="/page-pricing" className={`theme-btn btn-style-one ${plan.theme}`}>
                                                    <span className="btn-title">BOOKING NOW</span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                        <div className="content-column col-xl-5 order-xl-2">
                            <div className="inner-column wow fadeInRight">
                                <div className="sec-title">
                                    <span className="sub-title">PRICING OPTIONS</span>
                                    <h2>Our Electrician Pricing Plans.</h2>
                                    <div className="text">Lorem ipsum dolor sit amet consectetur adipiscing elit velit convallis enim vestibulum sagittis sapien inceptos.</div>
                                </div>
                                <div className="info-btn">
                                    <a href="tel:+01(2345)6789" className="info-btn-two">
                                        <i className="icon fa fa-phone"></i>
                                        <small>Call Anytime</small>
                                        <strong>+ 01 ( 2345 ) 6789</strong>
                                    </a>
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
