import React from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/resource/about4-thumb.jpg';
import AboutSide from './AboutSide.jsx';

function About({ className }) {
    return (
        <>
            
            <section className="blog-details">
                <div className="container">
                <div className="row">
                    <div className="col-xl-8 col-lg-7 general-details-page">
                        <h2>About Income Electrix Limited</h2>
                        
                        <div className="sec-about-title">
                        <span className="sub-title">African-preferred provider of electrical engineering solutions</span>
                        </div>
                        <div className='page-content'>
                        Income Electrix Limited (IEL) is a full value chain African preferred provider of electrical engineering solutions from concept development to handing over the keys.
                        <br/><br/>
                        IEL operates as a Group of companies  through Strategic Alliances, providing end-to-end electromechanical solutions, from developing Project Concepts through Engineering, Local  & foreign Procurement, Construction, Commissioning, Operations, Maintenance, Manufacturing, Management, and Utility
                        <br/><br/>
                        IEL manages a full range of techno-commercial support solutions which involves hardware, software and boots on the ground to the utilities and industries in Nigeria and Sub-Saharan Africa.</div>

                        
                        <h2>Our Edge</h2>
                        
                        <div className="sec-about-title">
                        <span className="sub-title">What makes us stand out</span>
                        </div>
                        <div className='page-content'>
                        <ul className="list-style-four">
                            <li>IEL is an African-preferred provider of electrical engineering solutions; with over three decades of verifiable experience in the West African power sector. 
                            </li>
                            <li>Experienced in difficult terrains; Niger Delta and  Northern Regions of Nigeria, Liberia and Sierra Leone. 
                            </li>
                            <li>Employees: Over 500 staff, with a senior management team possessing over 300 years of collective experience in the power sector. 
                            </li>
                            <li>The IEL Group, is comprised of companies operating in various sectors of the Energy Industry
                            </li>
                        </ul>
                        </div>

                        
                        <h2>What We Offer</h2>

                        <div className="sec-about-title">
                        <span className="sub-title">Professional Services we render to our clients</span>
                        </div>
                        <div className='page-content'>
                            <ul>
                                <li>Engineering Procurement and Construction (EPC): Generation, Transmission and Distribution.
                                </li>
                                <li>Engineering of Mechanical Systems: HVAC; Valves; Fabrication; Pumps; Vessels.
                                </li>
                                <li>Electrical & Instrumentation works: SCADA; Automation; Firefighting/deluge systems.
                                </li>
                                <li>Electrical Equipment Repairs/ Retrofitting: Transformers, Switchgear, Circuit Breakers, Motor Drives, High Voltage and Low Voltage Panels, Motor Control Centres (MCC), Drive Control Systems (DCS), etc
                                </li>
                                <li>Electricity Distribution (Utility - Power): Utility Operations & Management; IPPs/ Distributed Generation; Embedded Generation (Gas to Power, Renewables).
                                </li>
                                <li>Revenue Assurance: Hardware; Software; Boots on Ground.
                                </li>
                                <li>Manufacturing: Metering; Pre-stressed & pre-cast concrete products ; Electrical Components Assembly.

                                </li>
                            </ul>
                        </div>

                        
                        <section className={`about-section-eight general-details-page style-two ${className || ''}`}>
                            <div className="auto-container">
                                <div className="row">
                                    <div className="content-column col-md-12 col-sm-12 order-2 wow fadeInRight" data-wow-delay="600ms">
                                        <div className="inner-column">
                        
                                            <div className="btn-box">
                                                <div className="founder-info">
                                                    <div className="thumb"><img src={AboutThumbImg} alt="Image"/></div>
                                                    <h5 className="name">Dr. Matthew O. Edevbie</h5>
                                                    <span className="designation">Group Managing Director</span>
                                                </div>
                                                <Link to="/board-members" className="theme-btn btn-style-one bg-dark"><span className="btn-title">Explore now</span></Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                    <AboutSide />
                    {/*
                    <div className="col-xl-4 col-lg-5">
                        <div className="sidebar about_side">                            
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Subsidiaries</h3>
                                <ul className="sidebar__category-list list-unstyled about_in_side">
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Armese<span className="icon-right-arrow"></span></Link> </li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Kilowatt Engineering<span className="icon-right-arrow"></span></Link></li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> Skyview<span className="icon-right-arrow"></span></Link> </li>
                                    <li><Link to="/blog/blog-details"><i className="fa fa-long-arrow-right"></i> MSMSL<span className="icon-right-arrow"></span></Link> </li>
                                </ul>
                            </div>                         
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Core Values</h3>
                                <ul className="sidebar__category-list list-unstyled  about_in_side">
                                    <li><i className="fa fa-check-circle"></i> Professionalism<span className="icon-right-arrow"></span> </li>
                                    <li><i className="fa fa-check-circle"></i> Innovation<span className="icon-right-arrow"></span></li>
                                    <li><i className="fa fa-check-circle"></i> Reliability<span className="icon-right-arrow"></span> </li>
                                    <li><i className="fa fa-check-circle"></i> Integrity<span className="icon-right-arrow"></span> </li>
                                </ul>
                            </div>                          
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Mission</h3>
                                <div className="side-bar-content">"To Provide customized electrical engineering solutions to our valued customers through innovation, skilled workforce, technology and exceptional customer experience."
                                </div>
                            </div>                         
                            <div className="sidebar__single sidebar__category">
                                <h3 className="sidebar__title">Vision</h3>
                                <div className="side-bar-content">"To be the leading African provider of Electrical Engineering Solutions"</div>

                            </div>
                        </div>

                    </div>*/}

                </div>
            </div>
            </section>
        </>
    );
}

export default About;
