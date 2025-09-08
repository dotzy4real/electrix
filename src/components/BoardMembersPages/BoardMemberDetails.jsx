import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import ProgressBar from '../../lib/ProgressBar.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/board members.png';
const imgPath = '/src/assets/images/resource/pagebanners';

// Import images
import TeamDetailsImg from '../../assets/images/resource/board_members/mathew_edevbie.jpg';
const teamImgPath = '/src/assets/images/resource/board_members';

function TeamDetails() {
        
const { title } = useParams("title");
let id = null;
if (title && typeof title === "string")
{
    id = title.split("-").pop();
}
const navigate = useNavigate();

let memberExist = false;

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [member, setMember] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
    console.log("checking");
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getBoardMember/"+id);
        if (!response.ok) { console.log("it broke");
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        console.log("checking here");
        setMember(result);
        console.log("member board id: " + member.board_director_id);
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
        const response = await fetch(ApiUrl + "electrix/getPage/board_members");
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


  if (Object.keys(member).length !== 0)
  {
    memberExist = true;
  }


    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Board Member"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/board-members', title: data.page_breadcumb_title },
                    { title: member.board_director_name },
                ]}
                banner={imgPath+"/"+data.page_banner}
            />
            <section className="team-details">
                <div className=""/>
                <div className="container pb-100">

{ !memberExist ?             
                                    <div dangerouslySetInnerHTML={{ __html: "<h4>This board member you are looking for does not exist</h4>" }} /> : "" }

 
    {memberExist &&
                    <div className="team-details__top pb-70">
                        <div className="row">
                            <div className="col-xl-6 col-lg-6">
                                <div className="team-details__top-left">
                                    <div className="team-details__top-img"> <img src={teamImgPath+"/"+member.board_director_pic} alt="Image"/>
                                        <div className="team-details__big-text"></div>
                                    </div>
                                </div>
                            </div>
                            <div className="col-xl-6 col-lg-6">
                                <div className="team-details__top-right">
                                    <div className="team-details__top-content">
                                        <h3 className="team-details__top-name">{member.board_director_name}</h3>
                                        <p className="team-details__top-title">{member.board_director_designation}</p>
                                        <p className="page-content team">
                                        <div dangerouslySetInnerHTML={{ __html: member.board_director_content }} />
                                        
                                            {/*General Alexander Odeareduo Ogomudia (Rtd) CFR DSS FWC PSC(+) MSc FNSE is a retired Nigerian Military officer who served as Chief of Defence Staff and Chief of Army Staff.
<br/><br/>
General Ogomudia attended a number of military and civil courses at home and abroad. He attended Signal Officers Basic Course (SOBC 19) USA, Signals Officers' Degree Engineer Course (India), Diploma Electrical Electronics Engineering, Obafemi Awolowo University Ile-Ife, Battalion Commanders' Course Jaji, National War College Course Lagos and University of Ibadan amongst others.
<br/><br/>
He was appointed Chief of Army Staff in 2001 and served as Chief of Defence Staff of Nigeria from 2003 to 2006.
<br/><br/>
He joined the Nigerian Defence Academy (NDA) as a cadet in 1969 and is of NDA 7th Regular Course. He was commissioned in 1972 into the Nigerian Military Signal as Second Lieutenant with effect from October 1969. He grew through the ranks and held several senior military positions including; Directing Staff at Command and Staff College, Commander 53 Armoured Division Headquarters and Signal, Director of Telecommunications at Headquarters Nigerian Military Signals, Directing Staff, at National War College, Commandant Nigerian Military Signals and School and General Officer Commanding 1 Mechanized Division Nigerian Military.
<br/><br/>
He is married with children. His hobbies include Music, Farming and Engineering Design.*/}
</p>
                                        {(() => {
                                            if (member.board_director_email != "")
                                            {
                                                return (
                                        <div className="team-details-contact mb-30">
                                            <h5 className="mb-0">Email Address</h5>
                                            <div className=""><span>{member.board_director_email}</span></div>
                                        </div>);
                                        }
                                        })()}

                                        {(() => {
                                            if (member.board_director_phone != "")
                                            {
                                                return (
                                                <div className="team-details-contact mb-30">
                                                    <h5 className="mb-0">Phone Number</h5>
                                                    <div className=""><span>{member.board_director_phone}</span></div>
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
        }
                    {/*<div className="team-details__bottom pt-100">
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
                    </div>*/}
                </div>
            </section>


            {/*
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
            <BackToTop />
        </>
    );
}

export default TeamDetails;
