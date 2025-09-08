import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

// Import images
import TeamImg1 from '../../assets/images/resource/management_team/emmanuel_audu.jpg';
import TeamImg2 from '../../assets/images/resource/management_team/okotete.jpg';
import TeamImg3 from '../../assets/images/resource/management_team/chukwudi_esell.jpg';
import TeamImg4 from '../../assets/images/resource/management_team/jean_pierre_breton.jpg';
import TeamImg5 from '../../assets/images/resource/management_team/adegbite_olugbenga.jpg';
import TeamImg6 from '../../assets/images/resource/management_team/alero_eigbobo.jpg';
import TeamImg7 from '../../assets/images/resource/management_team/kenu_sarah.jpg';
import TeamImg8 from '../../assets/images/resource/management_team/nwaochuwku_iloanwsi.jpg';
import TeamImg9 from '../../assets/images/resource/management_team/eric_peekate.jpg';
const imgPath = '/src/assets/images/resource/management_team';

function ManagementTeam() {
	
const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [member, setMember] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

useEffect(() => {
	const fetchData = async () => {
	  try {
		const response = await fetch(ApiUrl + "electrix/fetchManagementTeam");
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
<section className="team-section pb-90">
    <div className="auto-container">
        <div className="row wow fadeInUp">

		{(() => { if (data.page_show_title == 'active') { 
                            return (    <div>
                        <h2>{data.page_title}</h2>
                        
                        <div className="sec-about-title">
                        <span className="sub-title">{data.page_title_caption}</span>
                        </div></div>)
                        }})()}
			
			
			{data.map(item => (
	
				<div className="col-lg-4 col-sm-6">
					<div className="team-block mb-30">
						<div className="inner-box">
						<div className="image-box">
							<figure className="image"><Link to={"/management-team/details/"+item.management_team_urltitle+"-"+item.management_team_id}><img src={imgPath+"/"+item.management_team_pic} alt="Image"/></Link></figure>
							<div className="info-box">
							<h4 className="name"><Link to={"/management-team/details/"+item.management_team_urltitle+"-"+item.management_team_id}>{item.management_team_name}</Link></h4>
							<span className="designation">{item.management_team_designation}</span> <span className="share-icon fa fa-share-alt"></span>
							<div className="social-links">
								<Link to={item.management_team_linkedin}><i className="fab fa-linkedin"></i></Link>
								<Link to={item.management_team_facebook}><i className="fab fa-facebook-f"></i></Link>
								<Link to={item.management_team_twitter}><i className="fab fa-twitter"></i></Link>
							</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			))}



{/*

      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg1} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/management-team-details">Engr. (Dr.) Emmanuel Audu-Ohwavborua (FNSE, PMP)</Link></h4>
			            <span className="designation">Executive Director Technical & Operations</span> <span className="share-icon fa fa-share-alt"></span>
			            <div className="social-links">
			              <Link to="#"><i className="fab fa-twitter"></i></Link>
			              <Link to="#"><i className="fab fa-linkedin"></i></Link>
			              <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
      	    </div>

            <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg2} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/management-team-details">Emmanuel Emuejevoke Okotete</Link></h4>
			          <span className="designation">Group Executive Director Commercial and Business Development</span> <span className="share-icon fa fa-share-alt"></span>
			          <div className="social-links">
			            <Link to="#"><i className="fab fa-twitter"></i></Link>
			            <Link to="#"><i className="fab fa-linkedin"></i></Link>
			            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			          </div>
			        </div>
			      </div>
			    </div>
            </div>
            <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg3} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/management-team-details">Chukwudi Essell</Link></h4>
			          <span className="designation">Group Chief Financial Officer</span> <span className="share-icon fa fa-share-alt"></span>
			          <div className="social-links">
			            <Link to="#"><i className="fab fa-twitter"></i></Link>
			            <Link to="#"><i className="fab fa-linkedin"></i></Link>
			            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			          </div>
			        </div>
			      </div>
			    </div>
            </div>
            <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg4} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/management-team-details">Jean-Pierre Breton</Link></h4>
			          <span className="designation">Chief Compliance Officer </span> <span className="share-icon fa fa-share-alt"></span>
			          <div className="social-links">
			            <Link to="#"><i className="fab fa-twitter"></i></Link>
			            <Link to="#"><i className="fab fa-linkedin"></i></Link>
			            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			          </div>
			        </div>
			      </div>
			    </div>
            </div>
            <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg5} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/management-team-details">Adegbite Olugbenga</Link></h4>
			          <span className="designation">Lead Technical Consultant</span> <span className="share-icon fa fa-share-alt"></span>
			          <div className="social-links">
			            <Link to="#"><i className="fab fa-twitter"></i></Link>
			            <Link to="#"><i className="fab fa-linkedin"></i></Link>
			            <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			          </div>
			        </div>
			      </div>
			    </div>
            </div>
      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg6} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/management-team-details">Gloria Alero Eigbobo (Mrs.)</Link></h4>
			            <span className="designation">General Manager Legal/Human Resources</span> <span className="share-icon fa fa-share-alt"></span>
			            <div className="social-links">
			              <Link to="#"><i className="fab fa-twitter"></i></Link>
			              <Link to="#"><i className="fab fa-linkedin"></i></Link>
			              <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
      	    </div>
      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg7} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/management-team-details">Engr. (Dr.) Kenu E. Sarah</Link></h4>
			            <span className="designation">GM, Renewable Energy & Special Projects</span> <span className="share-icon fa fa-share-alt"></span>
			            <div className="social-links">
			              <Link to="#"><i className="fab fa-twitter"></i></Link>
			              <Link to="#"><i className="fab fa-linkedin"></i></Link>
			              <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
      	    </div>
      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg8} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/management-team-details">Engr. (Dr.) Nwachukwu Iloanwusi</Link></h4>
			            <span className="designation">GM, Utility Support Services</span> <span className="share-icon fa fa-share-alt"></span>
			            <div className="social-links">
			              <Link to="#"><i className="fab fa-twitter"></i></Link>
			              <Link to="#"><i className="fab fa-linkedin"></i></Link>
			              <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
      	    </div>
      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/management-team-details"><img src={TeamImg9} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/management-team-details">Eric Peekate</Link></h4>
			            <span className="designation">Head Engineering</span> <span className="share-icon fa fa-share-alt"></span>
			            <div className="social-links">
			              <Link to="#"><i className="fab fa-twitter"></i></Link>
			              <Link to="#"><i className="fab fa-linkedin"></i></Link>
			              <Link to="#"><i className="fab fa-facebook-f"></i></Link>
			            </div>
			          </div>
			        </div>
			      </div>
			    </div>
			</div> */}
        </div>
    </div>
</section>
        </>
    );
}

export default ManagementTeam;
