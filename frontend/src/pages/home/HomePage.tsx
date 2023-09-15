import React from "react";
import "./home.scss";
import { Link } from "react-router-dom";
import { useUserContext } from "../../components/UserProvider";

const HomePage: React.FC<{}> = ({}) => {
  const token = useUserContext();

  return (
    <>
      <div className="home-page">
        {token !== null && (
          <Link to="/settings">
            <div className="box blog-card">
              <img src="/settings.svg" alt="" />
            </div>
          </Link>
        )}
        <Link to="/blogposts">
          <div className="box blog-card">
            <img src="/blog.png" alt="" />
          </div>
        </Link>
      </div>
    </>
  );
};

export default HomePage;
