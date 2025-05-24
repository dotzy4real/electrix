import React from 'react';
import Accordion from '../../lib/Accordion';
import FaqImage from '../../assets/images/resource/faq1-1.png';


function Faq({ className }) {
    return (
        <>
            <section className={`faq-section ${className || ''}`}>
                <div className="bg bg-pattern-1"/>
                <div className="shape-4 bounce-y"/>
                <div className="shape-31 bounce-y"/>
                <div className="auto-container">
                    <div className="outer-box">
                        <div className="row">
                            <div className="faq-column col-lg-6 wow fadeInLeft" data-wow-delay="300ms">
                                <div className="inner-column">
                                    <div className="sec-title">
                                        <span className="sub-title">CAPABILITIES</span>
                                        <h2>Services that help our customers meet</h2>
                                        <div className="text">With over four decades of experience providing solutions to large-scale enterprises throughout the globe, we offer end-to-end.</div>
                                    </div>
                                    <Accordion />
                                </div>
                            </div>
                            <div className="image-column col-lg-6">
                                <div className="inner-column">
                                    <div className="image-box">
                                        <figure className="image wow zoomInRight animated"><img src={FaqImage} alt="Image"/></figure>
                                        <div className="rating-box"> <i className="icon far fa-star"></i>
                                            <ul className="rating">
                                                <li><i className="fa fa-solid fa-star"></i></li>
                                                <li><i className="fa fa-solid fa-star"></i></li>
                                                <li><i className="fa fa-solid fa-star"></i></li>
                                                <li><i className="fa fa-solid fa-star"></i></li>
                                                <li><i className="fa fa-solid fa-star"></i></li>
                                            </ul>
                                            <h6 className="reviews">4.5 (1,200 reviews)</h6>
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

export default Faq;
