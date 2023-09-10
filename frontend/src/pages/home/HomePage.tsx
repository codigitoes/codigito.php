import React from 'react';
import './home.scss';
import { Link } from 'react-router-dom';

interface HomePageProps {
}

const HomePage: React.FC<HomePageProps> = ({ }) => {
    return (
        <>
            <div className='home-page'>
                <Link to="/blog">
                    <div className="box blog-card">
                        <img src="/blog.png" alt="" />
                    </div>
                </Link>
            </div>
        </>
    );
};

export default HomePage;
