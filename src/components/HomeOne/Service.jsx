import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import Service1 from '../../assets/images/resource/services/engineering_procurement.jpg';
import Service2 from '../../assets/images/resource/services/cms_energi.jpg';
import Service3 from '../../assets/images/resource/services/utility_operations.jpg';
import Service4 from '../../assets/images/resource/services/kilowatt_engineering.jpg';
import Service5 from '../../assets/images/resource/services/manufacturing.jpg';
import Service6 from '../../assets/images/resource/services/utility_operations.jpg';

const imgPath = '/src/assets/images/resource/services';

function Service({ className }) {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getHomeServices");
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
        {  dataLoaded && (
            <section id="services" className={`services-section ${className || ''}`}>
                <div className="icon-plane-2 bounce-y"/>
                <div className="auto-container">
                    <div className="sec-title text-center">
                        <span className="sub-title">WHAT WE DO</span>
                        <h2>We Offer Cost Efficient <br/> Electrical Services</h2>
                    </div>
                    <div className="row">
                        
                {data.map(item => (
        
                    <div className="service-block col-lg-4 col-md-6">
                        <div className="inner-box">
                            <div className="image-box">
                                <figure className="image"><Link to="/page-service-details"><img className="w-100" src={imgPath+"/"+item.service_small_pic} alt="Image"/></Link></figure>
                                <Link to="{/page-service-details}" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                            </div>
                            <div className="content-box">
                                <div className="info-box"> <i className={"icon " + item.service_icon}></i>
                                    <h4 className="title"><Link to="/page-service-details">{item.service_title}
                                    </Link></h4>
                                </div>
                                <div className="inner">
                                    <div className="text">{item.service_snippe}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                ))}



                        {/*
                        <div className="service-block col-lg-4 col-md-6">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-service-details"><img className="w-100" src={Service1} alt="Image"/></Link></figure>
                                    <Link to="/page-service-details" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                                </div>
                                <div className="content-box">
                                    <div className="info-box"> <i className="icon flaticon-028-pcb-board"></i>
                                        <h4 className="title"><Link to="/page-service-details">Engineering, Procurement & Construction (EPC)
                                        </Link></h4>
                                    </div>
                                    <div className="inner">
                                        <div className="text">We have over 30 years of experience in providing EPC Services in the African Power Sector</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="service-block col-lg-4 col-md-6">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-service-details"><img className="w-100" src={Service5} alt="Image"/></Link></figure>
                                    <Link to="/page-service-details" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                                </div>
                                <div className="content-box">
                                    <div className="info-box"> <i className="icon flaticon-050-protect"></i>
                                        <h4 className="title"><Link to="/page-service-details">Metering Solutions & Manufacturing Services 
                                        </Link></h4>
                                    </div>
                                    <div className="inner">
                                        <div className="text">We Successfully operate and manage the PHEDC electricity distribution network on behalf of 4Power Consortium investors</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="service-block col-lg-4 col-md-6">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-service-details"><img className="w-100" src={Service4} alt="Image"/></Link></figure>
                                    <Link to="/page-service-details" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                                </div>
                                <div className="content-box">
                                    <div className="info-box"> <i className="icon flaticon-050-protect"></i>
                                        <h4 className="title"><Link to="/page-service-details">KILOWATT ENGINEERING 
                                        </Link></h4>
                                    </div>
                                    <div className="inner">
                                        <div className="text">Transformer refurbishment, maintenance, repairs and replacement</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div className="service-block col-lg-4 col-md-6">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-service-details"><img className="w-100" src={Service2} alt="Image"/></Link></figure>
                                    <Link to="/page-service-details" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                                </div>
                                <div className="content-box">
                                    <div className="info-box"> <i className="icon flaticon-029-electric-meter"></i>
                                        <h4 className="title"><Link to="/page-service-details">CMS<br/>Enerji</Link></h4>
                                    </div>
                                    <div className="inner">
                                        <div className="text">We also have proven expertise in the construction of 132kV and 330kV Transmission Lines /Substations in difficult terrain</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="service-block col-lg-4 col-md-6">
                            <div className="inner-box">
                                <div className="image-box">
                                    <figure className="image"><Link to="/page-service-details"><img className="w-100" src={Service6} alt="Image"/></Link></figure>
                                    <Link to="/page-service-details" className="theme-btn read-more">READ MORE <i className="fa fa-arrow-up"></i></Link>
                                </div>
                                <div className="content-box">
                                    <div className="info-box"> <i className="icon flaticon-050-protect"></i>
                                        <h4 className="title"><Link to="/page-service-details">Utility Operations And Management Services
                                        </Link></h4>
                                    </div>
                                    <div className="inner">
                                        <div className="text">We Successfully operate and manage the PHEDC electricity distribution network on behalf of 4Power Consortium investors</div>
                                    </div>
                                </div>
                            </div>
                        </div> */}
                    </div>
                </div>
            </section>)}
        </>
    );
}

export default Service;
