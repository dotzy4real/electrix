import React from 'react';
import { Link } from 'react-router-dom';


function Service({ className }) {
    return (
        <>
            <section id="services" className={`services-section-four ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">WHAT WE ARE DO</span>
                        <h2>High quality products & services <br />that we stand behind</h2>
                    </div>
                    <div className="outer-box">
                        <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 justify-content-center">
                            <div className="service-block-four col wow fadeInUp">
                                <div className="inner-box ">
                                    <i className="icon flaticon-029-electric-meter"></i>
                                    <h4 className="title"><Link to="/page-service-details">Electric <br/>Installation</Link></h4>
                                    <div className="text">Sed non odio non elit porttitor Donec</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="200ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-001-light-bulb"></i>
                                    <h4 className="title"><Link to="/page-service-details">Indoor <br/>Lighting</Link></h4>
                                    <div className="text">Sed non odio non elit porttitor Donec</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="400ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-028-pcb-board"></i>
                                    <h4 className="title"><Link to="/page-service-details">Modification <br/>Service</Link></h4>
                                    <div className="text">Sed non odio non elit porttitor Donec</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="600ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-031-led-lamp"></i>
                                    <h4 className="title"><Link to="/page-service-details">Outdoor <br/>Lighting</Link></h4>
                                    <div className="text">Sed non odio non elit porttitor Donec</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="800ms">
                                <div className="inner-box">
                                    <i className="icon flaticon-040-switch"></i>
                                    <h4 className="title"><Link to="/page-service-details">24/7 <br/>Service</Link></h4>
                                    <div className="text">Sed non odio non elit porttitor Donec</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
}

export default Service;
