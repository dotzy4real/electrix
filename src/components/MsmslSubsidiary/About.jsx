import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import AboutThumbImg from '../../assets/images/resource/about1-thumb2.jpg';
import AboutImg1 from '../../assets/images/msmsl/about1.jpg';
import AboutImg2 from '../../assets/images/msmsl/about2.jpg';
import TeamImg1 from '../../assets/images/armese/team/team1.jpg';
import Popup from 'reactjs-popup';
import PopupBox from '../PopupBox.jsx';
const imgPath = '/src/assets/images/msmsl/';

function About({ className }) {    


    const ApiUrl = import.meta.env.VITE_API_URL;
    const [data, setData] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const [dataLoaded, setDataLoaded] = useState(false);
    
    useEffect(() => {
        const fetchData = async () => {
          try {
            const response = await fetch(ApiUrl + "msmsl/getHomeAbout");
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
            <section id="MsmslAbout" className={`about-section-eight style-two ${className || ''}`}>
                <div className="auto-container">
                    <div className="row">
                        <div className="content-column col-xl-6 col-lg-7 order-2 wow fadeInRight" data-wow-delay="600ms">
                            <div className="inner-column">
                                <div className="sec-title">
                                    <span className="sub-title">{data.msmsl_about_icon_title}</span>
                            <h2>{data.msmsl_about_title}{/*We provide best Metering Solution in town.*/}</h2>
                                    <div className="text">
                                    <div dangerouslySetInnerHTML={{ __html: data.msmsl_about_content }} />
                                        {/*Metering Solutions Manufacturing Services Limited (MSMSL) is an indigenous manufacturing and services company commissioned in September, 2017. Based in Onna, Akwa Ibom State, Nigeria, MSMSL currently boasts an ultra modern, 20,580sqm state-of-the-art assembly and manufacturing facility, with an installed capacity of three (3) million meters per annum.
                                        <br/><br/>
The facility produces high-tech smart and non-smart pre-paid electricity meters and meter boxes used in power measurement and revenue assurance locally and within the African region.*/}
</div>
                                </div>
                                {/*
                                <ul className="list-style-two">
                                    <li><i className="fa fa-check-circle"></i> Deliver Perfect Solution for business</li>
                                    <li><i className="fa fa-check-circle"></i> Readily Work With Global Brands solutions.</li>
                                    <li><i className="fa fa-check-circle"></i> Residential Business Installation</li>
                                </ul>*/}

                                <div className="btn-box">
                                    <div className="founder-info">
                                        <div className="thumb"><img src={imgPath + "team/" + data.msmsl_management_team_pic} alt="Image"/></div>
                                        <h5 className="name">{data.msmsl_management_team_name}</h5>
                                        <span className="designation">{data.msmsl_management_team_designation}</span>
                                    </div>
                                    {/*<a><span className="btn-title">View Profile</span></a>*/}
                                    <Popup
    trigger={<a className="theme-btn btn-style-one bg-dark"><span className="btn-title">View Profile</span></a>}
    modal
  >
    {close => (
      <PopupBox title="Management Team" content={<section className="team-details">
					<div className=""/>
					<div className="container pb-20">
						<div className="team-details__top pb-70">
							<div className="row">
								<div className="col-xl-3 col-lg-3">
									<div className="team-details__top-left">
										<div className="team-details__top-img"> <img src={imgPath + "team/" + data.msmsl_management_team_pic} alt="Image"/>
											<div className="team-details__big-text"></div>
										</div>
									</div>
								</div>
								<div className="col-xl-9 col-lg-9">
									<div className="team-details">
										<div className="team-details__top-content">
											<h4 className="team-details__top-name">{data.msmsl_management_team_name}</h4>
											<p className="team-details__top-title">{data.msmsl_management_team_designation}</p>
											<p className="page-content team">
                                                
                                            <div dangerouslySetInnerHTML={{ __html: data.msmsl_about_content }} />
                                                {/*Tolulope Ogunkolade is a seasoned and visionary Technology professional. 
<br/><br/>
He has over 15 years' experience spanning Power Generation from Diesel/Gas Generators, Supply Chain Management, World Class Manufacturing Operations, Quality Management Systems, Operational Excellence, CKD/SKD Technology, Lean Manufacturing, Six Sigma, TPM, Measurement Systems Analysis, APQQP/PPAP Engineering Operations Support Asset Reliability Strategy. 
<br/><br/>
He holds an MSc in Engineering Management from the Anglia Ruskin University and is a member of the Society of Corporate Governance of Nigeria and Nigeria Institute of Management Energy Management Association UK
*/}
	  </p>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Email Address</h5>
												<div className=""><span>{data.msmsl_management_team_email ?? "N/A"}</span></div>
											</div>
											<div className="team-details-contact mb-30">
												<h5 className="mb-0">Phone Number</h5>
												<div className=""><span>{data.msmsl_management_team_phone ?? "N/A"}</span></div>
											</div>
											<div className="team-details__social"> <Link to={data.msmsl_management_team_linkedin}><i className="fab fa-linkedin"></i></Link><Link to={data.msmsl_management_team_facebook}><i className="fab fa-facebook"></i></Link><Link to={data.msmsl_management_team_twitter}><i className="fab fa-twitter"></i></Link></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>} onClose={close} classProp='header' classClose='close' />
    )}
  </Popup>



                                </div>
                            </div>
                        </div>
                        <div className="image-column col-xl-6 col-lg-5">
                            <div className="inner-column wow fadeInLeft">
                                <figure className="image-1 overlay-anim wow fadeInUp"><img src={imgPath + data.msmsl_about_left_pic} alt="Image"/></figure>
                                <figure className="image-2 overlay-anim wow fadeInRight"><img src={imgPath + data.msmsl_about_right_pic} alt="Image"/></figure>
                                <div className="experience bounce-y">
                                    <div className="inner">
                                        <i className="icon flaticon-023-telephone-socket"></i>
                                        <div className="text"><strong>{data.msmsl_about_experience_years}+</strong> Years of <br />experience</div>
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
