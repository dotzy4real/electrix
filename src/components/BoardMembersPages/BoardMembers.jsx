import React from 'react';
import { Link } from 'react-router-dom';

// Import images
import TeamImg1 from '../../assets/images/resource/board_members/general_alexander.jpg';
import TeamImg2 from '../../assets/images/resource/board_members/kester_ifeader.jpg';
import TeamImg3 from '../../assets/images/resource/board_members/edward_ukiri.jpg';
import TeamImg4 from '../../assets/images/resource/board_members/clement_ofuani.jpg';
import TeamImg5 from '../../assets/images/resource/board_members/ajulu_okeke.jpg';
import TeamImg6 from '../../assets/images/resource/board_members/mathew_edevbie.jpg';
import TeamImg7 from '../../assets/images/resource/board_members/sani_bello.jpg';

function BoardMembers() {
    return (
        <>
<section className="team-section pb-90">
    <div className="auto-container">
        <div className="row wow fadeInUp">
      	    <div className="col-lg-4 col-sm-6">
			    <div className="team-block mb-30">
			      <div className="inner-box">
			        <div className="image-box">
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg1} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/board-member-details">General Alexander Ogomudia (Rtd.)</Link></h4>
			            <span className="designation">Chairman</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg2} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/board-member-details">Arc. Kester Ifeadi</Link></h4>
			          <span className="designation">Board Member</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg3} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/board-member-details">Barr. Ovie Edward Ukiri</Link></h4>
			          <span className="designation">Board Member</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg4} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/board-member-details">Chief Clement Ofuani</Link></h4>
			          <span className="designation">Board Member</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg5} alt="Image"/></Link></figure>
			        </div>
			        <div className="info-box">
			          <h4 className="name"><Link to="/board-member-details">HE Ambassador Uche Ajulu-Okeke</Link></h4>
			          <span className="designation">Board Member</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg6} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/board-member-details">Engr. (Dr.) Matthew O. Edevbie</Link></h4>
			            <span className="designation">Group Managing Director / CEO</span> <span className="share-icon fa fa-share-alt"></span>
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
			          <figure className="image"><Link to="/board-member-details"><img src={TeamImg7} alt="Image"/></Link></figure>
			          <div className="info-box">
			            <h4 className="name"><Link to="/board-member-details">Alhaji Ibrahim Sani Bello</Link></h4>
			            <span className="designation">Strategic Partner – Northern Region</span> <span className="share-icon fa fa-share-alt"></span>
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
        </div>
    </div>
</section>
        </>
    );
}

export default BoardMembers;
