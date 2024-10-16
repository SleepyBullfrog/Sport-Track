class CalculDistance {
  /**
   * Construit un objet de type CalculDistance
   */
  constructor() {}

  /**
   * Conversion d'un angle de degrées en radians
   * @param {float} degree - L'angle en degrées
   * @returns {float} L'angle en radians
   */
  degreeToRadian(degree) {
    return (degree * Math.PI) / 180;
  }

  /**
   * Calcule la distance entre deux points GPS
   * @param {float} lat1 - Latitude du premier point GPS
   * @param {float} long1 - Longitude du premier point GPS
   * @param {float} lat2 - Latitude du second point GPS
   * @param {float} long2 - Longitude du second point GPS
   * @returns {float} La distance entre les deux points GPS
   */
  calculDistance2PointsGPS(lat1, long1, lat2, long2) {
    const r = 6378.137; // Earth's radius in km
    return (
      r *
      Math.acos(
        Math.sin(this.degreeToRadian(lat2)) *
          Math.sin(this.degreeToRadian(lat1)) +
          Math.cos(this.degreeToRadian(lat2)) *
            Math.cos(this.degreeToRadian(lat1)) *
            Math.cos(this.degreeToRadian(long2) - this.degreeToRadian(long1)),
      )
    );
  }

  /**
   * Calcule la distance d'un parcours.
   * @param {Array} parcours - Un tableau contenant l'ensemble des points GPS du parcours.
   * @returns {float} La distance du parcours.
   */
  calculDistanceTrajet(parcours) {
    let distance = 0;
    for (let i = 0; i < parcours.length - 1; i++) {
      distance += this.calculDistance2PointsGPS(
        parcours[i].latitude,
        parcours[i].longitude,
        parcours[i + 1].latitude,
        parcours[i + 1].longitude,
      );
    }
    return distance;
  }
}

let activity = new CalculDistance();
activity.date = "01/09/2022";
activity.description = "IUT -> RU";

activity.parcours = [];
activity.parcours[0] = [];
activity.parcours[1] = [];
activity.parcours[2] = [];
activity.parcours[3] = [];
activity.parcours[4] = [];
activity.parcours[5] = [];

activity.parcours[0].time = "13:00:00";
activity.parcours[0].cardio_frequency = 99;
activity.parcours[0].latitude = 47.644795;
activity.parcours[0].longitude = -2.776605;
activity.parcours[0].altitude = 18;
activity.parcours[1].time = "13:00:05";
activity.parcours[1].cardio_frequency = 100;
activity.parcours[1].latitude = 47.646870;
activity.parcours[1].longitude = -2.778911;
activity.parcours[1].altitude = 18;
activity.parcours[2].time = "13:00:10";
activity.parcours[2].cardio_frequency = 102;
activity.parcours[2].latitude = 47.646197;
activity.parcours[2].longitude = -2.78022;
activity.parcours[2].altitude = 18;
activity.parcours[3].time = "13:00:15";
activity.parcours[3].cardio_frequency = 100;
activity.parcours[3].latitude = 47.646992;
activity.parcours[3].longitude = -2.781068;
activity.parcours[3].altitude = 17;
activity.parcours[4].time = "13:00:20";
activity.parcours[4].cardio_frequency = 98;
activity.parcours[4].latitude = 47.647867;
activity.parcours[4].longitude = -2.781744;
activity.parcours[4].altitude = 16;
activity.parcours[5].time = "13:00:25";
activity.parcours[5].cardio_frequency = 103;
activity.parcours[5].latitude = 47.648510;
activity.parcours[5].longitude = -2.780145;
activity.parcours[5].altitude = 16;

const result = activity.calculDistanceTrajet(activity.parcours);
console.log(result)