import React, { useEffect, useState } from 'react';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import BoardMembers from './BoardMembers.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/board members.png';
const imgPath = 'src/assets/images/resource/pagebanners';

function BoardDirectorPages() {

const ApiUrl = import.meta.env.VITE_API_URL;
const [data, setData] = useState([]);
const [edge, setEdge] = useState([]);
const [offer, setOffer] = useState([]);
const [member, setMember] = useState([]);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);

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


    return (
        <>
            <InnerHeader />
            <PageTitle
                title="Board Members"
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { title: data.page_breadcumb_title },
                ]}
                 banner={imgPath+"/"+data.page_banner}
            />
                
                {(() => { if (data.page_show_title == 'active') { 
                  return ( 
<section className="blog-details pt-120"> 
                <div className="auto-container general-details-page">
                                           <div>
                                    <h2>{data.page_title}</h2>
                                    
                                    <div className="sec-about-title">
                                    <span className="sub-title">{data.page_title_caption}</span>
                                    </div></div>
                                    </div></section> )
                                    }})()}
            <BoardMembers />
            <Footer />
            <BackToTop />
        </>
    );
}

export default BoardDirectorPages;
