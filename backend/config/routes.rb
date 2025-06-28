Rails.application.routes.draw do
  get "health" => "health#show", :as => :health
end
