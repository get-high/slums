import React, {useEffect} from 'react'
import {useDispatch, useSelector} from 'react-redux'
import {getSpots, getPageNumber, getPageCount, getSpotLoadingStatus} from '../slices/spotSlice'
import {fetchSpots} from '../actions/spotActions'
import ReactPaginate from 'react-paginate'
import {NavLink} from 'react-router-dom'

const Spots = () => {
  const spots = useSelector(getSpots);
  const page = useSelector(getPageNumber);
  const pageCount = useSelector(getPageCount);
  const loading = useSelector(getSpotLoadingStatus);
  const dispatch = useDispatch();

  function Spots({ currentSpots }) {
    return (
        <div>
            {currentSpots &&
              currentSpots.map((item) => (
                  <div key={item.id}>
                      <NavLink to={`/admin/spots/${item.id}`}>{item.title}</NavLink>
                  </div>
              ))}
        </div>
    );
  }

  const handlePageClick = (event) => {
      dispatch(fetchSpots(event.selected + 1))
  };

  useEffect(() => {
    if (spots.length === 0) {
      dispatch(fetchSpots(page))
    }
  }, [spots, dispatch]);

  return (
      <div>
          <div>
              <h1>Spots Manager</h1>
          </div>

          {!loading ? (
              <div>
                  <Spots currentSpots={spots} />
              </div>
          ) : (
              <div>Загрузка...</div>
          )}

          <div>
              <ReactPaginate
                  breakLabel="..."
                  nextLabel="next >"
                  onPageChange={handlePageClick}
                  pageCount={pageCount}
                  marginPagesDisplayed={2}
                  pageRangeDisplayed={5}
                  forcePage={page - 1}
                  previousLabel="< previous"
                  renderOnZeroPageCount={null}
                  containerClassName="pagination justify-content-center"
                  pageClassName="page-item"
                  pageLinkClassName="page-link"
                  previousClassName="page-item"
                  previousLinkClassName="page-link"
                  nextClassName="page-item"
                  nextLinkClassName="page-link"
                  activeClassName="active"
              />
          </div>
      </div>
  )
}

export default Spots
