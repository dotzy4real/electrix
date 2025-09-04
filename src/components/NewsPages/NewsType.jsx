import React, { useEffect, useState } from 'react';
import { Link, useParams, useNavigate  } from 'react-router-dom';
import moment from 'moment';
import BackToTop from '../BackToTop.jsx';
import InnerHeader from '../InnerHeader.jsx';
import Footer from '../HomeOne/Footer.jsx';
import PageTitle from '../PageTitle.jsx';
import News from './News.jsx';
import PageBanner from '../../assets/images/resource/pagebanners/blog.jpeg';
const bannerPath = '/src/assets/images/resource/pagebanners';
const imgPath = '/src/assets/images/resource/blog';

function NewsPages() {

const { name } = useParams("name");
const { type } = useParams("type");
let id = null;
let empty = false;
if (name && typeof name === "string")
{
  id = name.split("-").pop();
}
console.log("id is: " + id);
const ApiUrl = import.meta.env.VITE_API_URL;
const [page, setPage] = useState([]);
const [data, setData] = useState([]);
const [cat, setCat] = useState([]);
let [category, setCategory] = useState([]);
const [catEmpty, setCatEmpty] = useState(false);
const [loading, setLoading] = useState(true);
const [error, setError] = useState(null);
const [dataLoaded, setDataLoaded] = useState(false);
//let category = "";

/*
useEffect(() => {
  const fetchData = async () => {
    try {
    const response = await fetch(ApiUrl + "electrix/blogCategory/"+id);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const result = await response.json();
    setCat(result);
    if (cat && typeof cat === "undefined")
    {
      setCatEmpty(true);
    }
    } catch (error) {
    setError(error);
    } finally {
    setLoading(false);
    setDataLoaded(true);
    category = cat.blog_category_name;
    }
  };

  fetchData();
  }, []);*/
//console.log("my type is: " + type);
if (type == "category")
{
  useEffect(() => {
    const fetchData = async () => {
      try {
      const response = await fetch(ApiUrl + "electrix/getBlogCategory/"+id);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const result = await response.json();
      setData(result);
      setCategory(result[0].blog_category_name);
      } catch (error) {
      setError(error);
      } finally {
      setLoading(false);
      setDataLoaded(true);
      console.log("my category inside is: " + category);
      }
    };
  
    fetchData();
    }, []);

} else if (type == "tag")
{
  useEffect(() => {
    const fetchData = async () => {
      try {
      const response = await fetch(ApiUrl + "electrix/getBlogTag/"+id);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const result = await response.json();
      setData(result);
      setCategory(result[0].blog_tag_name);
      } catch (error) {
      setError(error);
      } finally {
      setLoading(false);
      setDataLoaded(true);
      }
    };
  
    fetchData();
    }, []);

}
if (data.length === 0)
{
  empty = true;
} 

useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await fetch(ApiUrl + "electrix/getPage/blog");
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        setPage(result);
      } catch (error) {
        setError(error);
      } finally {
        setLoading(false);
        setDataLoaded(true);
      }
    };

    fetchData();
  }, []);

  console.log("my category outside is: " + category);

    return (
        <>
            <InnerHeader />
            <PageTitle
                title={page.page_title}
                breadcrumb={[
                    { link: '/', title: 'Home' },
                    { link: '/blog', title: page.page_breadcumb_title },
                    { title: category },
                ]}
                banner={bannerPath+"/"+page.page_banner}
            /><section className="news-section">
                  <div className="auto-container">
                    <div className="row">
            { empty ?             
                                    <div dangerouslySetInnerHTML={{ __html: "<h4>There are no blog posts under this category</h4>" }} /> : "" }
                    {data.map(item => (
            
                    <div key={item.blog_id} className="news-block col-lg-4 col-sm-6 wow fadeInUp">
                        <div className="inner-box">
                          <div className="image-box">
                            <figure className="image"><Link to={"/blog/details/"+item.blog_id}><img src={imgPath+"/"+item.blog_pic} alt="Image"/></Link></figure>
                            <span className="date"><b>{moment(item.added_time).format('DD')}</b>{moment(item.added_time).format("MMM' YY")}</span>
                          </div>
                          <div className="content-box">
                            <ul className="post-info">
                              <li><i className="fa fa-user"></i> By admin</li>
                              <li><i className="fa fa-tag"></i> {item.blog_category_name}</li>
                            </ul>
                            <h4 className="title"><Link to={"/blog/details/"+item.blog_id}>{item.blog_title}</Link></h4>
                          </div>
                          <div className="bottom-box">
                            <Link to={"/blog/details/"+item.blog_id} className="read-more">READ MORE <i className="fa fa-long-arrow-alt-right"></i></Link>
                            {/*<div className="comments"><i className="fa fa-comments"></i> (05)</div>*/}
                          </div>
                        </div>
                      </div>
             ))}
                    </div>
                  </div>
                </section>
            <Footer />
            <BackToTop />
        </>
    );
}

export default NewsPages;
