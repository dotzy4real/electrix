import React from 'react';
import {Link} from 'react-router-dom';
{/*
import ProjectThumb1 from '../../assets/images/resource/project-thumb-1.jpg';
import ProjectThumb2 from '../../assets/images/resource/project-thumb-2.jpg';
import ProjectThumb3 from '../../assets/images/resource/project-thumb-3.jpg';
import ProjectThumb4 from '../../assets/images/resource/project-thumb-4.jpg';
import ProjectThumb5 from '../../assets/images/resource/project-thumb-5.jpg';
import ProjectThumb6 from '../../assets/images/resource/project-thumb-6.jpg';*/}
import FooterBgImage from '../../assets/images/pattern/shape-1.png';
import ProjectThumb1 from '../../assets/images/resource/projects/252mw_gas.jpg';
import ProjectThumb2 from '../../assets/images/resource/projects/36.5_emergency.jpg';
import ProjectThumb3 from '../../assets/images/resource/projects/20mw_gas_plant.jpg';
import ProjectThumb4 from '../../assets/images/resource/projects/3mw_diesel_powerplant.jpg';
import ProjectThumb5 from '../../assets/images/resource/projects/transmission_substation.jpg';

function Footer({ className }) {
    return (
        <>
            <footer className={`main-footer ${className || ''}`}>
            <div className="bg-image" style={{ backgroundImage: `url(${FooterBgImage})` }}/>
                <div className="widgets-section">
                    <div className="auto-container">
                        <div className="row">
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget about-widget">
                                    <h5 className="about-title">About us</h5>
                                    <div className="text">Income Electrix Limited (IEL) is an African-preferred provider of electrical engineering solutions.</div>
                                    <ul className="social-icon-two">
                                        <li><Link to="#"><i className="fab fa-twitter"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-instagram"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-facebook"></i></Link></li>
                                        <li><Link to="#"><i className="fab fa-linkedin-in"></i></Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget">
                                    <h5 className="widget-title">Explore</h5>
                                    <ul className="user-links">
                                        <li><Link to="/who-we-are">About Company</Link></li>
                                        <li><Link to="/management-team">Meet the Team</Link></li>
                                        <li><Link to="/blog">Blog</Link></li>
                                        <li><Link to="#">Our Projects</Link></li>
                                        <li><Link to="/contact">Contact</Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget contact-widget">
                                    <h5 className="widget-title">Contact</h5>
                                    <div className="widget-content">
                                        <div className="text">POWER HOUSE<br/>
Km 16, Port Harcourt-Aba Expressway
Port Harcourt, Rivers State – Nigeria.</div>
                                        <ul className="contact-info">
                                            <li><i className="fa fa-envelope"></i> <a href="mailto:info@incomeelectrix.com
">info@incomeelectrix.com</a><br /></li>
                                            <li><i className="fa fa-phone-square"></i> <a href="tel:07055990728">+234 (0) 7055990728</a>, <a href="tel:07055990729">+234 (0) 7055990729 </a><br /></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget gallery-widget">
                                    <h5 className="widget-title">Portfolio</h5>
                                    <div className="widget-content">
                                        <div className="outer clearfix">
                                            <figure className="image">
                                                <Link to="/what-we-have-done/project-details">
                                                    <img src={ProjectThumb1} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="/what-we-have-done/project-details">
                                                    <img src={ProjectThumb2} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="/what-we-have-done/project-details">
                                                    <img src={ProjectThumb3} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="/what-we-have-done/project-details">
                                                    <img src={ProjectThumb4} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="/what-we-have-done/project-details">
                                                    <img src={ProjectThumb5} alt=""/>
                                                </Link>
                                            </figure>
                                            {/*<figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb6} alt=""/>
                                                </Link>
                                            </figure>*/}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="footer-bottom">
                    <div className="auto-container">
                        <div className="inner-container">
                            <div className="copyright-text">&copy; 2025 <Link to="/">Income Electrix Limited</Link> | All Rights Reserved
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
}

export default Footer;
