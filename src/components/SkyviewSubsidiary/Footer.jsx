import React, { useEffect, useState } from 'react';
import {Link} from 'react-router-dom';
import ProjectThumb1 from '../../assets/images/kilowatt/projects/project1.jpg';
import ProjectThumb2 from '../../assets/images/kilowatt/projects/project2.jpg';
import ProjectThumb3 from '../../assets/images/kilowatt/projects/project3.jpg';
import ProjectThumb4 from '../../assets/images/kilowatt/projects/project4.jpg';
import ProjectThumb5 from '../../assets/images/kilowatt/projects/project2.jpg';
import ProjectThumb6 from '../../assets/images/kilowatt/projects/project1.jpg';

function Footer({ className }) {
    
    
    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "skyview/getContactInfo");
            if (!response.ok) {
              throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();
            setData(result);
          } catch (error) {
            setError(error);
          } finally {
            setLoading(false);
            setDataLoaded(true);
          }
        };
    
        fetchData();
      }, []);

    return (
        <>
            <footer className={`main-footer ${className || ''}`}>
                <div className="widgets-section">
                    <div className="auto-container skyview">
                        <div className="row">
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget about-widget">
                                    <h5 className="about-title">About us</h5>
                                    <div className="text">Skyview Power Technologies Limited is a leading Nigerian engineering solutions provider, delivering expert consultancy and execution across the mechanical and electrical sectors</div>
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
                                        <li><Link to="#">About Company</Link></li>
                                        <li><Link to="#">Meet the Team</Link></li>
                                        <li><Link to="#">News & Media</Link></li>
                                        <li><Link to="#">Our Projects</Link></li>
                                        <li><Link to="#">Contact</Link></li>
                                    </ul>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget contact-widget">
                                    <h5 className="widget-title">Contact</h5>
                                    <div className="widget-content">
                                        <div className="text">{/*3B Oroma Close, Off Olu – Obasoanjo  Road,  Port Harcourt, Rivers State*/}
                                        {data.skyview_contact_info_address}
                                        </div>
                                        <ul className="contact-info">
                                            {/*<li><i className="fa fa-envelope"></i> <Link to="mailto:needhelp@yourdomain.com">needhelp@company.com</Link><br /></li>*/}
                                            {/*<li><i className="fa fa-phone-square"></i> <Link to="tel:080333677033">08033367703</Link><br /></li>*/}<li><i className="fa fa-phone-square"></i> <Link to={"tel:"+data.skyview_contact_info_phone}>{data.skyview_contact_info_phone}</Link><br /></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div className="footer-column col-lg-3 col-sm-6">
                                <div className="footer-widget gallery-widget">
                                    <h5 className="widget-title">Gallery</h5>
                                    <div className="widget-content">
                                        <div className="outer clearfix">
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb1} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb2} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb3} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb4} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb5} alt=""/>
                                                </Link>
                                            </figure>
                                            <figure className="image">
                                                <Link to="#">
                                                    <img src={ProjectThumb6} alt=""/>
                                                </Link>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="footer-bottom skyview">
                    <div className="auto-container">
                        <div className="inner-container">
                            <div className="copyright-text">&copy; 2025 <Link to="/">Skyview</Link> | All Rights Reserved
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </>
    );
}

export default Footer;
