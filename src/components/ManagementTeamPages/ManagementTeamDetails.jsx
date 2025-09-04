import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import ProgressBar from '../../lib/ProgressBar.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/management_team.png';
const imgPath = '/src/assets/images/resource/pagebanners';

// Import images
import TeamDetailsImg from '../../assets/images/resource/management_team/emmanuel_audu.jpg';
const teamImgPath = '/src/assets/images/resource/management_team';

function TeamDetails() {


const { id } = useParams("id");
const navigate = useNavigate();

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [member, setMember] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);
const [memberLoaded, setMemberLoaded] = useState(false);

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getManagementTeam/"+id);
        if (!response.ok) { console.log("it broke");
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        console.log("checking here");
        setMember(result);
        console.log("member board id: " + member.management_team_id);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setDataLoaded(true);
      }
    };

    fetchData();
  }, []);


useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getPage/management_team");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        setData(result);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setMemberLoaded(true);
      }
    };

    fetchData();
  }, []);


    return (
        <>
        {  memberLoaded && ( <div>
            <InnerHeader />
            <PageTitle
                title="Management Team"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/management-team', title: data.page_breadcumb_title },
                    { title: member.management_team_name },
                ]}
                banner={imgPath+"/"+data.page_banner}
            />





{(() => {
                                            if (member.length === 0)
                                            {
            {navigate('/page-doest-not-exist')}
                                            } else {
            
return (
            <section className="team-details">
                <div className=""/>
                <div className="container pb-100">
                    <div className="team-details__top pb-70">
                        <div className="row">
                            <div className="col-xl-6 col-lg-6">
                                <div className="team-details__top-left">
                                    <div className="team-details__top-img"> <img src={teamImgPath+"/"+member.management_team_pic} alt="Image"/>
                                        <div className="team-details__big-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-6">
                                <div className="team-details__top-right">
                                    <div className="team-details__top-content">
                                        <h3 className="team-details__top-name">{member.management_team_name}</h3>
                                        <p className="team-details__top-title">{member.management_team_designation}</p>
                                        <p className="page-content team">
                                        <div dangerouslySetInnerHTML={{ __html: member.management_team_content }} />
                                        
</p>
                                        {(() => {
                                            if (member.management_team_email != "")
                                            {
                                                return (
                                        <div className="team-details-contact mb-30">
                                            <h5 className="mb-0">Email Address</h5>
                                            <div className=""><span>{member.management_team_email}</span></div>
                                        </div>);
                                        }
                                        })()}

                                        {(() => {
                                            if (member.management_team_phone != "")
                                            {
                                                return (
                                                <div className="team-details-contact mb-30">
                                                    <h5 className="mb-0">Phone Number</h5>
                                                    <div className=""><span>{member.management_team_phone}</span></div>
                                                </div>);
                                        }
                                        })()}
                                        {/*
                                        <div className="team-details-contact">
                                            <h5 className="mb-0">Web Address</h5>
                                            <div className=""><span>www.yourdomain.com</span></div>
                                        </div>*/}
                                        <div className="team-details__social"> <Link to="#"><i className="fab fa-linkedin"></i></Link><Link to="#"><i className="fab fa-facebook"></i></Link><Link to="#"><i className="fab fa-twitter"></i></Link></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/*

                                            


            <section className="team-details">
                            <div className=""/>
                            <div className="container pb-100">
                                <div className="team-details__top pb-70">
                                    <div className="row">
                                        <div className="col-xl-6 col-lg-6">
                                            <div className="team-details__top-left">
                                                <div className="team-details__top-img"> <img src={TeamDetailsImg} alt="Image"/>
                                                    <div className="team-details__big-text"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-6">
                                            <div className="team-details__top-right">
                                                <div className="team-details__top-content">
                                                    <h3 className="team-details__top-name">Engr. (Dr.) Emmanuel Audu-Ohwavborua (FNSE, PMP)</h3>
                                                    <p className="team-details__top-title">Executive Director Technical & Operations</p>
                                                    <p className="page-content team">Engr. Dr. Emmanuel Audu-Ohwavborua (FNSE, PMP), is an administrator, a certified Project Manager (PMP), an entrepreneur with an interest in commercial agriculture, and a Fellow of the Nigeria Society of Engineers (FNSE), with over 30 years of experience working in diverse sectors ranging from Engineering Designs, Industrial and Production Management, Through Power Plant Engineering to Project Management. 
<br/><br/>
In 2023, he retired after twenty-two years of public service at the Niger Delta Development Commission, (NDDC), where he rose to the position of Acting Managing Director / CEO of the Public Sector Organization. He also served as Director, Project Monitoring & Supervision at, Bayelsa State Office, Akwa Ibom State Office, Delta State Office, at various times, and the Chairman of the NDDC Public-Private Partnership Committee just before he exited.
<br/><br/>
A graduate with a B.Sc. (Hons) in Electrical Engineering from the University of Ibadan in 1991.  He also has a Certificate in Effective Project Management from Lagos Business School, a master’s degree in business administration at the University of Calabar, and a certificate in Negotiation at the Harvard Law School, Boston, USA. In May 2015, he completed a programme on “Business Model Innovations' at the Cambridge Judge Business School, Cambridge University and in March 2019, he was awarded a Doctor of Business Administration (DBA), with a specialization in Project Management by the Commonwealth University (CUB).
            </p>
                                                    <div className="team-details-contact mb-30">
                                                        <h5 className="mb-0">Email Address</h5>
                                                        <div className=""><span>info@incomeelectrix.com</span></div>
                                                    </div>
                                                    <div className="team-details-contact mb-30">
                                                        <h5 className="mb-0">Phone Number</h5>
                                                        <div className=""><span>+012-3456-789</span></div>
                                                    </div>
                                                    <div className="team-details__social"> <Link to="#"><i className="fab fa-linkedin"></i></Link><Link to="#"><i className="fab fa-facebook"></i></Link><Link to="#"><i className="fab fa-twitter"></i></Link></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="team-details__bottom pt-100">
                                    <div className="row">
                                        <div className="col-xl-6 col-lg-6">
                                            <div className="team-details__bottom-left">
                                                <h4 className="team-details__bottom-left-title">Personal Experience</h4>
                                                <p className="team-details__bottom-left-text">When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries architecto dolorem ipsum quia</p>
                                            </div>
                                        </div>
                                        <div className="col-xl-6 col-lg-6">
                                            <div className="team-details__bottom-right">
                                                <div className="team-details__progress">
                                                    <ProgressBar title="Technology" targetPercentage={90} />
                                                    <ProgressBar title="Marketing" targetPercentage={80} />
                                                    <ProgressBar title="Business" targetPercentage={70} />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>*/}


</div>
            </section>)
        }
})()}

                        {/*}
            <section className="team-contact-form">
                <div className="container pb-100">
                    <div className="sec-title text-center">
                        <span className="sub-title">Contact With Us Now</span>
                        <h2 className="section-title__title">Feel Free to Write Our <br/> Tecnology Experts</h2>
                    </div>
                    <div className="row justify-content-center">
                        <div className="col-lg-8">
                            <form id="contact_form" name="contact_form" action="/page-team-details" method="get">
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_name" className="form-control" type="text" placeholder="Enter Name"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_email" className="form-control required email" type="email" placeholder="Enter Email"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_subject" className="form-control required" type="text" placeholder="Enter Subject"/>
                                        </div>
                                    </div>
                                    <div className="col-sm-6">
                                        <div className="mb-3">
                                            <input name="form_phone" className="form-control" type="text" placeholder="Enter Phone"/>
                                        </div>
                                    </div>
                                </div>
                                <div className="mb-3">
                                    <textarea name="form_message" className="form-control required" rows="5" placeholder="Enter Message"></textarea>
                                </div>
                                <div className="mb-3 text-center">
                                    <input name="form_botcheck" className="form-control" type="hidden" value="" />
                                    <button type="submit" className="theme-btn btn-style-two me-2" data-loading-text="Please wait..."><span className="btn-title">Send message</span></button>
                                    <button type="reset" className="theme-btn btn-style-two"><span className="btn-title">Reset</span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>*/}
            <Footer />
            <BackToTop /></div>)}
        </>
    );
}

export default TeamDetails;
