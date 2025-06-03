import React from 'react';
import { Link } from 'react-router-dom';


function Service({ className }) {
    return (
        <>
            <section id="services" className={`services-section-four ${className || ''}`}>
                <div className="auto-container">
                    <div className="sec-title text-center kilowatt">
                        <span className="sub-title">HOW WE WORK</span>
                        <h2>How we work and provide <br />high quality services</h2>
                    </div>
                    <div className="outer-box kilowatt">
                        <div className="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-5 justify-content-center">
                            <div className="service-block-four col wow fadeInUp">
                                <div className="inner-box ">
                                    <i className="icon flaticon-029-electric-meter"></i>
                                    <h4 className="title"><Link to="/page-service-details">Conception <br/>& Initiation</Link></h4>
                                    <div className="text">Project Charter Project Initiation</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="200ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-001-light-bulb"></i>
                                    <h4 className="title"><Link to="/page-service-details">Definition <br/>& Planning</Link></h4>
                                    <div className="text">Scope & Budget Work Breakdown Schedule</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="400ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-028-pcb-board"></i>
                                    <h4 className="title"><Link to="/page-service-details">Launch <br/>& Execution</Link></h4>
                                    <div className="text">Status & Tracking KPIs Quality Forecasts</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="600ms">
                                <div className="inner-box ">
                                    <i className="icon flaticon-031-led-lamp"></i>
                                    <h4 className="title"><Link to="/page-service-details">Performanc <br/>& Control</Link></h4>
                                    <div className="text">Objectives Quality Deliverables, Effort & Cost Tracking, Performance</div>
                                </div>
                            </div>
                            <div className="service-block-four col wow fadeInUp" data-wow-delay="800ms">
                                <div className="inner-box">
                                    <i className="icon flaticon-040-switch"></i>
                                    <h4 className="title"><Link to="/page-service-details">Project <br/>Close</Link></h4>
                                    <div className="text">Post mortem, Project Punchlist, Reporting</div>
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
