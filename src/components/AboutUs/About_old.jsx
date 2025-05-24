import React from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/resource/about4-thumb.jpg';
import AboutImg1 from '../../assets/images/resource/about4.png';
import AboutImg2 from '../../assets/images/resource/about4-tiny.png';

function About({ className }) {
    return (
        <>
            <section className={`about-section-eight style-two pt-120 ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 col-md-12 col-sm-12 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="sub-title">WHO WE ARE</span>
                                    <h2>Africa electrical engineering solutions Leader</h2>
                                    <div className="text">Income Electrix Limited (IEL) is a full value chain African preferred provider of electrical engineering solutions from concept development to handing over the keys.
                                        {/*<br/><br/>
                                        IEL operates as a Group of companies  through Strategic Alliances, providing end-to-end electromechanical solutions, from developing Project Concepts through Engineering, Local  & foreign Procurement, Construction, Commissioning, Operations, Maintenance, Manufacturing, Management, and Utility
                                        <br/><br/>
                                        IEL manages a full range of techno-commercial support solutions which involves hardware, software and boots on the ground to the utilities and industries in Nigeria and Sub-Saharan Africa.*/}

                                    </div>

                                
                                
                                </div>

                                <ul className="list-style-two">
                                    <li><i className="fa fa-check-circle"></i> IEL is an African-preferred provider of electrical engineering solutions; with over three decades of verifiable experience in the West African power sector. 
                                    </li>
                                    <li><i className="fa fa-check-circle"></i> Experienced in difficult terrains; Niger Delta and  Northern Regions of Nigeria, Liberia and Sierra Leone. 
                                    </li>
                                    <li><i className="fa fa-check-circle"></i> Employees: Over 500 staff, with a senior management team possessing over 300 years of collective experience in the power sector. 
                                    </li>
                                </ul>

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
                        <div className="image-column col-xl-6 col-lg-5 col-md-12 col-sm-12">
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
