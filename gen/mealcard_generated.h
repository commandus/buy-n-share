// automatically generated by the FlatBuffers compiler, do not modify


#ifndef FLATBUFFERS_GENERATED_MEALCARD_BS_H_
#define FLATBUFFERS_GENERATED_MEALCARD_BS_H_

#include "flatbuffers/flatbuffers.h"

#include "buynshare_generated.h"

namespace bs {

inline const bs::MealCard *GetMealCard(const void *buf) {
  return flatbuffers::GetRoot<bs::MealCard>(buf);
}

inline bool VerifyMealCardBuffer(
    flatbuffers::Verifier &verifier) {
  return verifier.VerifyBuffer<bs::MealCard>(nullptr);
}

inline void FinishMealCardBuffer(
    flatbuffers::FlatBufferBuilder &fbb,
    flatbuffers::Offset<bs::MealCard> root) {
  fbb.Finish(root);
}

}  // namespace bs

#endif  // FLATBUFFERS_GENERATED_MEALCARD_BS_H_
